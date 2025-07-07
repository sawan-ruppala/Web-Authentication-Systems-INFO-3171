# Web-Authentication-Systems-Info-3171

I've created a few things
- A power point with a basic outline: 
- Two login systems:
 - Vulnerable System: Purposefully vulnerable to demonstrate sql injection, xss, session hijacking. It lacks pass encryption (hashing), pass rules, input sanitization, and pdo statements. I’ll record a demo tomorrow to show exactly how it’s exploitable and post it on PowerPoint.
 - Secure System: This addresses all the issues mentioned above. I’ll also record a demo showing how it protects against those attacks and mention the techniques.
- I'll use the secure secure system to complete the remaining two login security features: MFA and Encrypted DB
 - For MFA, I'll use Google Auth cause it's free.
 - For DB encryption, I'll google around or wait till next class.
- I also made a simple login system selector page with 5 buttons to toggle between the different systems (one of them being the vulnerable one).
- I'll upload all this shit onto github and i can guarantee that it works cause i actually tested it this time. So you're free to use it as a templet.

DB SQL Code - Will be updated for more features like multi factor

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,  
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP    
);

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ip_address VARCHAR(45),
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
