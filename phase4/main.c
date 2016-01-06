//
//  main.c
//  
//
//  Created by Stefan Kofler on 04.01.16.
//
//

#include <stdio.h>
#include <mysql.h>
#include <stdlib.h>

int main (int argc, char **argv) {
    char *databaseServer = "localhost";
    char *databaseUsername = "root";
    char *databasePassword = "kjvl4lvn";
    char *databaseName = "securecoding";
    
    char* programName = argv[0];
    char* filename = argv[1];
    
    char sourceUsername[1024];
    char targetUsername[1024];
    char tan[1024];
    
    int amount = 0;
    int fails = 0;
    
    int sourceID = 0;
    int targetID = 0;
    int balance = 0;
    
    char query[1024];
    
    FILE *fileHandler = NULL;
    
    MYSQL *connection = mysql_init(NULL);
    MYSQL_RES *result;
    MYSQL_ROW row;

    if (argc <= 1) {
        fprintf(stderr, "Usage %s filename\n", programName);
        exit(255);
    }
    
    fileHandler = fopen(filename, "r");
    if (fileHandler == NULL) {
        fprintf(stderr, "Could not read input file");
        exit(254);
    }
    
    connection = mysql_real_connect(connection, databaseServer, databaseUsername, databasePassword, databaseName, 0, NULL, 0);
    if (connection == NULL) {
        const char* errorMessage = mysql_error(connection);
        fprintf(stderr, "%s\n", errorMessage);
        mysql_close(connection);
        exit(253);
    }
    
    if (fscanf(fileHandler, "%1024[^,],%1024[^,],%1024[^,],%d\n", sourceUsername, targetUsername, tan, &amount) == 4) {
        int sourceUserExists = 0;
        int enoughMoney = 0;
        int tanExists = 0;
        int targetAccountExists = 0;
        
        sprintf(query, "SELECT * FROM users where uname = '%s';", sourceUsername);
        mysql_query(connection, query);
        result = mysql_store_result(connection);
        
        if (mysql_num_rows(result) > 0) {
            sourceUserExists = 1;
            row = mysql_fetch_row(result);
            sscanf(row[0], "%d", &sourceID);
            sscanf(row[6], "%d", &balance);
            if (balance >= amount) {
                enoughMoney = 1;
            }
        }
        
        sprintf(query, "SELECT uid, value FROM tans WHERE uid=%d and value='%s'", sourceID, tan);
        mysql_query(connection, query);
        result = mysql_store_result(connection);
        printf("query: %s\n", query);

        if (mysql_num_rows(result) > 0) {
            printf("TAN is valid\n");
            tanExists = 1;
        }
        
        sprintf(query, "SELECT * FROM users where uname = '%s';", targetUsername);
        mysql_query(connection, query);
        result = mysql_store_result(connection);
        
        if (mysql_num_rows(result) > 0) {
            targetAccountExists = 1;
            row = mysql_fetch_row(result);
            sscanf(row[0], "%d", &targetID);
        }

        printf("%d %d %d %d\n", sourceUserExists, targetAccountExists, tanExists, enoughMoney);
        if (sourceUserExists != 0 && targetAccountExists != 0 && tanExists != 0 && enoughMoney != 0) {
            int approvalStatus = 1;
            if (amount > 10000) {
                approvalStatus = 0;
            }
            
            sprintf(query, "INSERT INTO transactions (sourceId, targetId, tan, date, amount,approved) VALUES (%d,%d,'%s',CURDATE(),%d,%d)", sourceID, targetID, tan, amount, approvalStatus);
            mysql_query(connection, query);
            result = mysql_store_result(connection);

            sprintf(query, "DELETE FROM tans WHERE uid=%d AND value=‚%s'", sourceID, tan);
            mysql_query(connection, query);
            result = mysql_store_result(connection);
            
            if (amount > 0 && approvalStatus != 0) {
                sprintf(query, "UPDATE users SET balance=balance+%d WHERE uid=%d", amount, targetID);
                mysql_query(connection, query);

                sprintf(query, "UPDATE users SET balance=balance-%d WHERE uid=%d", amount, sourceID);
                mysql_query(connection, query);
            }
        } else {
            fails += 1;
        }
        
    }
    
    mysql_free_result(result);
    mysql_close(connection);
    fclose(fileHandler);
    
    return fails;
}