This is a very simple web interface for managing domains, email accounts and automatic BCC copies.
It is not nice and beautiful as PostfixAdmin and does not support vacation messages (they are handled by Sieve filter in Dovecot).
What you can do with this tool is:

(1) you can add / rename / remove domains from Postfix - assuming you have the following directive in your "/etc/postfix/main.cf" file

virtual_mailbox_domains = proxy:mysql:/etc/postfix/virtual_domain_sql 

(2) you can assign a supervisor for any domain (no more than 1 per domain - but several domains can be supervised by the same person)
(3) you can create / edit / delete accounts for domain supervisors and for Master administrators (those who are allowed to create domains and supervisors)
(4) you can create / edit / delete / deactivate / reactivate  email accounts for domains supervised by yourself - assuming you have the following directive in your "/etc/postfix/main.cf" file

virtual_mailbox_maps = proxy:mysql:/etc/postfix/vmailbox_sql 

(5) you can specify a list of other mail accounts which will receive BCC copies of incoming and outgoing messages for the given email account (e.g. the boss of the person, the boss of the boss, and so on) 
for domains supervised by yourself - assuming you have the following directives in your "/etc/postfix/main.cf" file

sender_bcc_maps = proxy:mysql:/etc/postfix/sender_bcc_sql
recipient_bcc_maps = proxy:mysql:/etc/postfix/sender_bcc_sql 

(6) you can create / edit / delete aliases which may point to multiple accounts and/or other aliases for domains supervised by yourself (e.g. "engineering@your-domain.com" can point to all engineers) -
assuming you have the following directive in your "/etc/postfix/main.cf" file

virtual_alias_maps = proxy:mysql:/etc/postfix/virtual_sql 


Contents of "virtual_domain_sql":
=================================
hosts = 127.0.0.1
user = postfixadmin
password = postfixadmin
dbname = postfix
query = SELECT 1 FROM domain WHERE domain = _utf8'%s' COLLATE utf8_general_ci 

Contents of "vmailbox_sql":
===========================
hosts = 127.0.0.1
user = postfixadmin
password = postfixadmin
dbname = postfix
query = SELECT CONCAT('/var/mail/vhosts/',SUBSTRING_INDEX(_cp1251'%s' COLLATE cp1251_general_ci,'@',-1),'/',SUBSTRING_INDEX(_cp1251'%s' COLLATE cp1251_general_ci,'@',1),'/') FROM users WHERE active='Y' AND userid = _cp1251'%s' COLLATE cp1251_general_ci 

Contents of "sender_bcc_sql":
=============================
hosts = 127.0.0.1
user = postfixadmin
password = postfixadmin
dbname = postfix
query = SELECT goto FROM sender_bcc WHERE sender = _cp1251'%s' COLLATE cp1251_general_ci

Contents of "virtual_sql":
==========================
hosts = 127.0.0.1
user = postfixadmin
password = postfixadmin
dbname = postfix
query = SELECT goto FROM virtual WHERE address = _cp1251'%s' COLLATE cp1251_general_ci 


----------------
Postfix.SQL file contains definition for MySQL tables, needed by this tool:
(a) domain = domains, recognized as local
(b) users = mail accounts
(c) virtual = aliases
(d) sender_bcc = recipients of BCC copies
(e) domain_user = domain supervisors