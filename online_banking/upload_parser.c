#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <netinet/in.h>
#include <netdb.h>
#include <regex.h>
#include <strings.h>
#include <mysql/mysql.h>
#include <sys/types.h>

/**
 * opens the port 5555 and expects a file with the following format:
 * sender_id(account number),recipient_id(account number),amount,TAN
 * and the following regular expression has to be matched
 * [0-9]{10},[0-9]{10},[0-9]{1, 10}\.?[0-9]{0,2},[a-zA-Z0-9]{15}
 * So max 48 charactes + \0 character are accepted
 * Padding the account_numbers with zeros in front is allowed
 */

#define PORT        5555
#define SERVER      "localhost"
#define USER        "root"
#define PASSWORD    "samurai"
#define DATABASE    "securecoding"

int main(int argc, char* argv[]) {
    char filePathBuffer[200];
    char fileFirstLine[64];
    int i, reti;
    FILE *data;
    size_t len = 64;
    regex_t regex;

    fileFirstLine[63] = 0x00;

    // Reading filepath
    strncpy(filePathBuffer, argv[1], 199);
    filePathBuffer[199] = 0x00;

    data = fopen(filePathBuffer, "r");

    if (data == NULL) {
        printf("<strong>Error!</strong> Could not open the file.\n");
        exit(2);
    }

    if (fgets(fileFirstLine, len, data) == NULL) {
        fclose(data);
        printf("<strong>Error!</strong> Could not read the file.\n");
        exit(1);
    }


    fclose(data);
    int endofline = strlen(fileFirstLine) - 1;
    if ((endofline > 0) && (fileFirstLine[endofline] == '\n')) {
        fileFirstLine[endofline] = 0x00;
    }

    // printf("Here is the line: %s\n%i", fileFirstLine, strlen(fileFirstLine));

    reti = regcomp(&regex, "^[0-9]\\{10\\},[0-9]\\{10\\},[0-9]\\{1,10\\}[.]\\{0,1\\}[0-9]\\{0,2\\},[a-zA-Z0-9]\\{15\\}$", 0);
    if (reti) {
        printf("<strong>Error!</strong> Parsing Error! Something went wrong (regex)!\n");
        exit(1);
    }

    reti = regexec(&regex, fileFirstLine, 0, NULL, 0);
    if (!reti) {
        //Match
        char data[5][16];
        int index = 0, subindex = 0;
        char *temp_buffer;
        char delimiter[2] = ",";

        memset (data, 0, sizeof (data));

        temp_buffer = strtok(fileFirstLine, delimiter);
        strcpy(data[0], temp_buffer);

        for (i = 1; i < 4; i++) {
            temp_buffer = strtok(NULL, delimiter);
            strcpy(data[i], temp_buffer);
        }
        {
            /*
             * Check and insert data in the MYSQL database
             */
            MYSQL *conn;
            MYSQL_ROW row;
            MYSQL_STMT *stmt;
            MYSQL_BIND param[3];
            MYSQL_RES *result;
            int k;
            char query[300];
            char check_query[200];
            char tan_id[31];
            double amount = strtod(data[2], NULL);
            char date_text[10];
            my_bool is_null_date = 0;
            conn = mysql_init(NULL);

            /* Connect to database */
            if (!mysql_real_connect(conn, SERVER, USER, PASSWORD, DATABASE, 0, NULL, 0)) {
                //perror(mysql_error(conn));
                printf("<strong>Error!</strong> Could not connect to the database!\n");
                exit(1);
            }

            mysql_real_escape_string(conn, tan_id, data[3], 15);
            {
                char temp[200] = "SELECT ta.id FROM tans ta WHERE ta.user_id = \"%s\" and ta.id = \"%s\" and ta.id NOT IN (SELECT tr.tan_id FROM transactions tr)";
                snprintf(check_query, 199, temp, data[0], tan_id);
            }
            if (mysql_query(conn, check_query)) {
                printf("<strong>Error!</strong> Error in tan checking!\n");
                mysql_close(conn);
                exit(1);
            }

            result = mysql_store_result(conn);

            if (result == NULL) {
                printf("<strong>Error!</strong> Result for tan checking is NULL!\n");
                mysql_close(conn);
                exit(1);
            }

            if (mysql_num_rows(result) != 1) {
                printf("<strong>Error!</strong> Either your TAN id was wrong or it was already used!\n");
                mysql_free_result(result);
                mysql_close(conn);
                exit(2);
            }

            mysql_free_result(result);

            if (amount >= 10000) {
                strcpy(date_text, "null");
            } else {
                strcpy(date_text, "NOW()");
            }

            stmt = mysql_stmt_init(conn);
            {
                char temp[200] = "INSERT INTO transactions(sender_id, recipient_id, amount, approval_date, tan_id) VALUES(%s, %s, ?, %s, ?)";
                snprintf(query, 300, temp, data[0], data[1], date_text);
            }
            if (stmt == NULL) {
                printf("<strong>Error!</strong> Could not initialize statement handler.\n");
                mysql_close(conn);
                exit(1);
            }

            // Prepare the statement
            if (mysql_stmt_prepare(stmt, query, strlen(query)) != 0) {
		            // perror(mysql_error(conn));
                printf("<strong>Error!</strong> Could not prepare statement");
                mysql_close(conn);
                exit(1);
            }

            memset (param, 0, sizeof (param));

            param[0].buffer_type = MYSQL_TYPE_DOUBLE;
            param[0].buffer = (void *) &amount;
            param[0].is_unsigned = 0;
            param[0].is_null = 0;
            param[0].length = 0;

            param[1].buffer_type = MYSQL_TYPE_STRING;
            param[1].buffer = (void *) &data[3];
            param[1].buffer_length = strlen(data[3]);
            param[1].is_null = 0;
            param[1].length = 0;

            if (mysql_stmt_bind_param(stmt, param) != 0) {
		            // perror(mysql_error(conn));
                printf("<strong>Error!</strong> Could not bind parameters\n");
                mysql_stmt_close(stmt);
                mysql_close(conn);
                exit(1);
            }

            if (mysql_stmt_execute(stmt) != 0) {
		            // perror(mysql_error(conn));
                printf("<strong>Error!</strong> Could not execute statement\n");
                mysql_stmt_close(stmt);
                mysql_close(conn);
                exit(1);
            }

            if (mysql_affected_rows(conn) != 1) {
                printf("<strong>Error!</strong> Could not insert Transaction.\n");
                mysql_stmt_free_result(stmt);
                mysql_stmt_close(stmt);
                mysql_close(conn);
                exit(1);
            }

            // close connection
            mysql_stmt_free_result(stmt);
            mysql_stmt_close(stmt);
            mysql_close(conn);
            printf("<strong>Success!</strong> Your transaction has been stored.\n");
        }
    } else if (reti == REG_NOMATCH) {
        printf("<strong>Error!</strong> Your data does not correspond the allowed definition!\n");
        exit(2);
    } else {
        printf("<strong>Error!</strong> Regex match failed\n");
        exit(1);
    }

    return 0;
}
