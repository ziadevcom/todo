-- User Table

CREATE TABLE users (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	email TEXT NOT NULL,
	name TEXT NOT NULL,
	password TEXT NOT NULL,
	email_verified BOOLEAN DEFAULT TRUE,
    created_at TEXT DEFAULT (datetime('now')),
    updated_at TEXT DEFAULT (datetime('now'))
);

-- Tasks Table

CREATE TABLE tasks(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	title TEXT NOT NULL,
	description TEXT NOT NULL,
	completed BOOLEAN DEFAULT FALSE NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    updated_at TEXT DEFAULT (datetime('now')),
    user_id INTEGER NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);