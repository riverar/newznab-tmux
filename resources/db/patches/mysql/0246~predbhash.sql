ALTER TABLE predbhash DROP INDEX ix_predbhash_hashes;
ALTER TABLE predbhash DROP INDEX ix_predbhash_hashes_ft;
DROP TRIGGER IF EXISTS insert_hashes;
DROP TRIGGER IF EXISTS update_hashes;
DROP TRIGGER IF EXISTS delete_hashes;
RENAME TABLE predbhash TO predb_hashes;

DELIMITER $$
CREATE TRIGGER insert_hashes AFTER INSERT ON predb FOR EACH ROW BEGIN INSERT INTO predb_hashes (hash, pre_id) VALUES (UNHEX(MD5(NEW.title)), NEW.id), (UNHEX(MD5(MD5(NEW.title))), NEW.id), ( UNHEX(SHA1(NEW.title)), NEW.id);END; $$

CREATE TRIGGER update_hashes AFTER UPDATE ON predb FOR EACH ROW BEGIN IF NEW.title != OLD.title THEN DELETE FROM predb_hashes WHERE hash IN ( UNHEX(md5(OLD.title)), UNHEX(md5(md5(OLD.title))), UNHEX(sha1(OLD.title)) ) AND pre_id = OLD.id; INSERT INTO predb_hashes (hash, pre_id) VALUES ( UNHEX(MD5(NEW.title)), NEW.id ), ( UNHEX(MD5(MD5(NEW.title))), NEW.id ), ( UNHEX(SHA1(NEW.title)), NEW.id );END IF;END; $$

CREATE TRIGGER delete_hashes AFTER DELETE ON predb FOR EACH ROW BEGIN DELETE FROM predb_hashes WHERE hash IN ( UNHEX(md5(OLD.title)), UNHEX(md5(md5(OLD.title))), UNHEX(sha1(OLD.title)) ) AND pre_id = OLD.id;END; $$

DELIMITER ;
