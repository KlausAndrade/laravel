Dica sobre migrations

You need to run the composer dumpautoload command to generate a new classmap every time you add a file to database/, otherwise it will not be autoloaded.
