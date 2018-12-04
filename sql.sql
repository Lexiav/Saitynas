
 The following SQL statements will be executed:

     ALTER TABLE question_bank ADD CONSTRAINT FK_868E5295B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id);
     ALTER TABLE user_answers DROP FOREIGN KEY FK_8DDD80C1E5D0459;
     ALTER TABLE user_answers DROP FOREIGN KEY FK_8DDD80CA76ED395;
     DROP INDEX IDX_8DDD80CA76ED395 ON user_answers;
     DROP INDEX IDX_8DDD80C1E5D0459 ON user_answers;
     ALTER TABLE user_answers ADD user_test_id INT DEFAULT NULL, ADD question_id INT DEFAULT NULL, DROP user_id, DROP test_id;
     ALTER TABLE user_answers ADD CONSTRAINT FK_8DDD80C46501A53 FOREIGN KEY (user_test_id) REFERENCES user_tests (id);
     ALTER TABLE user_answers ADD CONSTRAINT FK_8DDD80C1E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id);
     CREATE INDEX IDX_8DDD80C46501A53 ON user_answers (user_test_id);
     CREATE INDEX IDX_8DDD80C1E27F6BF ON user_answers (question_id);
