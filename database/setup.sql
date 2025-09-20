-- Cleanslate

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS tasks;

-- User Table

create Table users (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	email TEXT NOT NULL,
	name TEXT NOT NULL,
	password TEXT NOT NULL,
	email_verified BOOLEAN DEFAULT TRUE,
    created_at TEXT DEFAULT (datetime('now')),
    updated_at TEXT DEFAULT (datetime('now'))
);

-- Tasks Table

create Table tasks(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	title TEXT NOT NULL,
	description TEXT NOT NULL,
	complete BOOLEAN DEFAULT FALSE NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    updated_at TEXT DEFAULT (datetime('now')),
    user_id INTEGER NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);