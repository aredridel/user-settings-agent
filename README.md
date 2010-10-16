A frontend PHP that SSHes to the server and starts the daemon running as the
user; it receives the magic cookie, and then connects over a unix-domain socket
to the agent, authorizes with the key, and then can run various tasks as the
user.

The protocol is SMTP-like, in that commands that take data expect data to
terminate with \n.\n. Responses are SMTP-like, though based on HTTP codes: 100
Continue; 200 OK; 400 BAD; 500 Internal error.

The primary purpose of this is to let my users schedule cronjobs, alter
vacation messages, and change passwords, all securely and without any unusual
setuid code.  Since my servers allow SSH access anyway, users don't gain any
privilege with this, just convenience
