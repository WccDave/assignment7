CREATE TABLE files
(
  file_id      int       NOT NULL AUTO_INCREMENT,
  file_name    char(50)  NOT NULL ,
  file_path char(50)     NULL ,
  PRIMARY KEY (file_id)
) ENGINE=InnoDB;


##########################
# Populate customers table
##########################
INSERT INTO files(file_id, file_name, file_path)
VALUES(10001, 'test.pdf', '/test.pdf');
