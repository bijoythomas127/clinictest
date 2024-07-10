INSERT INTO questions (`id`, `question`, `min_score`, `max_score`, `include_in_total_score`, `order`)
    VALUES 
    (1, 'How much relief have pain treatments or medications <b>FROM THIS CLINIC</b> provided?', 0, 100, 0, 1),
    (2, "Please rate your pain based on the number that best describes your pain at it's <b>WORST</b> in the past week.", 0, 10, 1, 2),
    (3, "Please rate your pain based on the number that best describes your pain at it's <b>LEAST</b> in the past week.", 0, 10, 1, 3),
    (4, 'Please rate your pain based on the number that best describes your pain on the <b>Average</b>', 0, 10, 1, 4),
    (5, 'Please rate your pain based on the number that best describes your pain that tells how much pain you have <b>RIGHT</b> NOW', 0, 10, 1, 5),
    (6, 'Based on the number that best describes how during the past week pain has <b>INTERFERED</b> with your: General Activity', 0, 10, 1, 6),
    (7, 'Based on the number that best describes how during the past week pain has <b>INTERFERED</b> with your: Mood', 0, 10, 1, 7),
    (8, 'Based on the number that best describes how during the past week pain has <b>INTERFERED</b> with your: Walking ability', 0, 10, 1, 8),
    (9, 'Based on the number that best describes how during the past week pain has <b>INTERFERED</b> with your: Normal work (includes work both outside the home and housework)', 0, 10, 1, 9),
    (10, 'Based on the number that best describes how during the past week pain has <b>INTERFERED</b> with your: Relationships with other people', 0, 10, 1, 10),
    (11, 'Based on the number that best describes how during the past week pain has <b>INTERFERED</b> with your: Sleep', 0, 10, 1, 11),
    (12, 'Based on the number that best describes how during the past week pain has <b>INTERFERED</b> with your: Enjoyment of life', 0, 10, 1, 12)
    ON DUPLICATE KEY UPDATE
    `question` = VALUES(`question`),
    `min_score` = VALUES(`min_score`),
    `max_score` = VALUES(`max_score`),
    `include_in_total_score` = VALUES(`include_in_total_score`),
    `order` = VALUES(`order`);