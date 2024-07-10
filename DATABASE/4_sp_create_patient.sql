DROP PROCEDURE IF EXISTS `create_patient_with_questions`;



CREATE PROCEDURE create_patient_with_questions(
    IN p_firstname VARCHAR(50),
    IN p_surname VARCHAR(50),
    IN p_dob DATE,
    IN p_questions JSON
)
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE max_i INT;
    DECLARE patient_id INT;

    INSERT INTO patients (first_name, surname, dob)
    VALUES (p_firstname, p_surname, p_dob);

    SET patient_id = LAST_INSERT_ID();

    SET max_i = JSON_LENGTH(p_questions);

    WHILE i < max_i DO
        INSERT INTO patient_questions (patient_id, question_id, score)
        VALUES (
            patient_id,
            JSON_UNQUOTE(JSON_EXTRACT(p_questions, CONCAT('$[', i, '].question_id'))),
            JSON_UNQUOTE(JSON_EXTRACT(p_questions, CONCAT('$[', i, '].score')))
        );
        SET i = i + 1;
    END WHILE;
END;
