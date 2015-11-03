# SecureCoding-Group3

For the current parser install libmysqlclient-dev with apt-get on vm and compile
with the following command:
	gcc -o upload_parser upload_parser.c \`mysql_config --cflags --libs\`
