# Projetos-Ter o wamp server instalado na máquina
-Nos arquivos que conectam com o banco de dados,trocar os valores de  $dbusername e $dbpassword  para seu proprio login e senha
-No localhost/phpmyadmin :
criar a database “oficina”
criar a table “orcamentos”  com o seguinte comando:
CREATE TABLE orcamentos (
    id int NOT NULL AUTO_INCREMENT,
    descricao varchar(255) NOT NULL,
    nome_Cliente varchar(255) NOT NULL,
    nome_Vendedor varchar(255) NOT NULL,
    preco decimal(6,2) NOT NULL,
    horario datetime NOT NULL,
    PRIMARY KEY (id)
);	
