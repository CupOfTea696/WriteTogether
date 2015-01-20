# projectwebperiode2
Project Web Periode 2

## Members
 - Thomas Claessens / Front-end
 - Sven Wittevrongel / Back-end

### Notes
 - Spend a really long time in figuring out some of the Mailgun errors. Turns out their error messages are just incomplete. Traced the issue all they way back to the [mailgun-php](https://github.com/mailgun/mailgun-php) package and [fixed](https://github.com/mailgun/mailgun-php/pull/72) it. There was also an [issue](https://github.com/Bogardo/Mailgun/issues/39) reported in [Bogardo/Mailgun](https://github.com/Bogardo/Mailgun) through which I finally discovered where the real problem was.
