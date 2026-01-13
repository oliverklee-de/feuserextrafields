#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users
(
	full_salutation            varchar(255) DEFAULT '' NOT NULL,
	gender                     tinyint(2) unsigned DEFAULT 99 NOT NULL,
	date_of_birth              int(11) DEFAULT 0 NOT NULL,
	zone                       varchar(45)  DEFAULT '' NOT NULL,
	privacy                    tinyint(1) unsigned DEFAULT 0 NOT NULL,
	privacy_date_of_acceptance int(11) unsigned DEFAULT 0 NOT NULL,
	terms_acknowledged         tinyint(1) unsigned DEFAULT 0 NOT NULL,
	terms_date_of_acceptance   int(11) unsigned DEFAULT 0 NOT NULL,
	status                     tinyint(1) unsigned DEFAULT 0 NOT NULL,
	comments                   text,
	department                 varchar(128) DEFAULT '' NOT NULL,
	vat_in                     varchar(15)  DEFAULT '' NOT NULL
);
