CREATE TABLE IF NOT EXISTS patient_questions (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    patient_id INT(11) NOT NULL,
    question_id INT(11) NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (question_id) REFERENCES questions(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;