DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS agents;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS hashtags;
DROP TABLE IF EXISTS ticket_hashtag;
DROP TABLE IF EXISTS faq;
DROP TABLE IF EXISTS document_attachments;
DROP TABLE IF EXISTS ticket_watching;

CREATE TABLE users(
    user_id INTEGER PRIMARY KEY AUTOINCREMENT, /*utilizei o AUTOINCREMENT pois a cada registo que o sistema recebe, o id incrementa sempre*/
    username VARCHAR UNIQUE NOT NULL, /*utilizei VARCHAR em vez de CHAR pois pode variar o tamanho*/
    password VARCHAR NOT NULL,
    first_name VARCHAR NOT NULL,
    last_name VARCHAR NOT NULL,
    email VARCHAR UNIQUE NOT NULL,
    role TEXT NOT NULL,
    department_id INTEGER,
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);

CREATE TABLE departments (   
    department_id INTEGER PRIMARY KEY,
    name varchar(255) NOT NULL
);

CREATE TABLE agents(
    agent_id INTEGER,
    department_id INTEGER,
    PRIMARY KEY (agent_id,department_id)
);

CREATE TABLE tickets(
    ticket_id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR,
    description TEXT,
    status TEXT CHECK(status IN ('open', 'closed')),
    priority TEXT CHECK(priority IN ('low', 'medium', 'high')),
    submitter_id INTEGER,
    assignee_id INTEGER,
    department_id INTEGER,
    creation_date DATETIME, /*UTILIZEI O DATETIME EM VEZ DE DATE PARA INCLUIR AS HORAS A QUE O TICKET FOI CRIADO*/
    update_date DATETIME,
    closed_date DATETIME,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (submitter_id) REFERENCES users(user_id),
    FOREIGN KEY (assignee_id) REFERENCES users(user_id),
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);

CREATE TABLE hashtags(
    hashtag_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR UNIQUE
);


CREATE TABLE ticket_hashtag(
    ticket_id INTEGER,
    hashtag_id INTEGER,
    PRIMARY KEY (ticket_id, hashtag_id)
    FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtags(hashtag_id)
);

CREATE TABLE faq(
    faq_id INTEGER PRIMARY KEY AUTOINCREMENT,
    question VARCHAR,
    answer TEXT,
    department_id INTEGER
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);
    
CREATE TABLE document_attachments(
    attachment_id INTEGER PRIMARY KEY AUTOINCREMENT,
    ticket_id INTEGER,
    file_name VARCHAR,
    file_path VARCHAR,
    FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id)
);

CREATE TABLE ticket_watching(
    ticket_id INTEGER,
    agent_id INTEGER,
    PRIMARY KEY (ticket_id, agent_id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id),
    FOREIGN KEY (agent_id) REFERENCES users(user_id)
);




CREATE INDEX idx_users_department_id ON users (department_id);
CREATE INDEX idx_agents_department_id ON agents (department_id);
CREATE INDEX idx_tickets_submitter_id ON tickets (submitter_id);
CREATE INDEX idx_tickets_assignee_id ON tickets (assignee_id);
CREATE INDEX idx_tickets_department_id ON tickets (department_id);
CREATE INDEX idx_ticket_hashtag_ticket_id ON ticket_hashtag (ticket_id);
CREATE INDEX idx_ticket_hashtag_hashtag_id ON ticket_hashtag (hashtag_id);
CREATE INDEX idx_faq_department_id ON faq (department_id);
CREATE INDEX idx_document_attachments_ticket_id ON document_attachments (ticket_id);
CREATE INDEX idx_ticket_watching_ticket_id ON ticket_watching (ticket_id);
CREATE INDEX idx_ticket_watching_agent_id ON ticket_watching (agent_id);

INSERT INTO users (username, password, first_name, last_name, email, role, department_id) VALUES ('jdoe', '$2y$10$s5UouxVyYLUPOjTKNgBFzOIgm1.A0g8j8OlP5r/qytT6O2xwhtmcm', 'John', 'Doe', 'jdoe@example.com', 'admin', 1); --password1
INSERT INTO users (username, password, first_name, last_name, email, role, department_id) VALUES ('jsmith', '$2y$10$OF6qMFm4k4RUQVVM65ZUUu8CE.w6Wn4EL8NBf9SGZwCcynhmvEsVm', 'Jane', 'Smith', 'jsmith@example.com', 'agent', 1); --password2
INSERT INTO users (username, password, first_name, last_name, email, role, department_id) VALUES ('mjordan', '$2y$10$FafGOJMm/CyYcBCqTCD5gu5NwCqvrwvuEUvSmUShQQJGIfcuxccRa', 'Michael', 'Jordan', 'mjordan@example.com', 'user', 2); -- password3

INSERT INTO departments (name) VALUES ('Customer Support');
INSERT INTO departments (name) VALUES ('Technical Support');
INSERT INTO departments (name) VALUES ('Billing');

INSERT INTO agents (agent_id, department_id) VALUES (2, 1);
INSERT INTO agents (agent_id, department_id) VALUES (3, 2);
INSERT INTO agents (agent_id, department_id) VALUES (4, 3);

INSERT INTO tickets (title, description, status, priority, submitter_id, assignee_id, department_id, creation_date, update_date) VALUES ('Printer issue', 'The printer is not working.', 'open', 'high', 3, 2, 1, '2023-04-01 10:00:00', '2023-04-01 10:00:00');
INSERT INTO tickets (title, description, status, priority, submitter_id, assignee_id, department_id, creation_date, update_date) VALUES ('Slow computer', 'My computer is running very slow.', 'open', 'medium', 3, 2, 1, '2023-04-02 11:00:00', '2023-04-02 11:00:00');
INSERT INTO tickets (title, description, status, priority, submitter_id, assignee_id, department_id, creation_date, update_date) VALUES ('Benefits inquiry', 'What are my health insurance benefits?', 'open', 'low', 3, 4, 2, '2023-04-03 12:00:00', '2023-04-03 12:00:00');

INSERT INTO hashtags (name) VALUES ('#hardware');
INSERT INTO hashtags (name) VALUES ('#software');
INSERT INTO hashtags (name) VALUES ('#hr');

INSERT INTO ticket_hashtag (ticket_id, hashtag_id) VALUES (1, 1);
INSERT INTO ticket_hashtag (ticket_id, hashtag_id) VALUES (2, 2);
INSERT INTO ticket_hashtag (ticket_id, hashtag_id) VALUES (3, 3);

INSERT INTO faq (question, answer, department_id) VALUES ('How do I reset my password?', 'Click on the "Forgot Password" link on the login page and follow the instructions.', 1);
INSERT INTO faq (question, answer, department_id) VALUES ('How do I request vacation days?', 'Submit a time-off request through the HR portal.', 2);
INSERT INTO faq (question, answer, department_id) VALUES ('How do I submit an expense report?', 'Use the finance portal to submit your expense report with receipts.', 3);

INSERT INTO document_attachments (ticket_id, file_name, file_path) VALUES (1, 'printer_error_log.txt', '/attachments/printer_error_log.txt');
INSERT INTO document_attachments (ticket_id, file_name, file_path) VALUES (2, 'slow_computer_screenshot.png', '/attachments/slow_computer_screenshot.png');
INSERT INTO document_attachments (ticket_id, file_name, file_path) VALUES (3, 'benefits_summary.pdf', '/attachments/benefits_summary.pdf');

INSERT INTO ticket_watching (ticket_id, agent_id) VALUES (1, 2);
INSERT INTO ticket_watching (ticket_id, agent_id) VALUES (2, 2);
INSERT INTO ticket_watching (ticket_id, agent_id) VALUES (3, 4);

