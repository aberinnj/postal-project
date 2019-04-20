Welcome to Group 1's (Tuesday/Thursday) postal office project!

INSTRUCTIONS (FRONT END):
There's a couple of things to keep in mind before using this project that might be confusing if you aren't aware of them but actually help immensely with keeping the data organized and relevant to those logged in.

1. There are a series of "offices" associated with certain states. However not every state has an office. This is important.

2. Each employee works for an office. When an employee logs in they will see package information relating to only to that office (except in the reports) which they choose when they register; in other words they will not see packages sent to other offices, and so won't be able to manage and deliver those packages, only packages sent to their office.

3. When a customer creates a package, they have to specify their address, including the state they reside in. Likewise, they also have to specify which nearby office they want to drop their package off at to send it to its final destination for them. So a customer in Texas can only take their packages to offices in Texas. This is important, because not every state has an office, so you will not have a choice of any offices to take your package to if you pick. This is not a bug.

4. An employee CAN do interstate shipments, however they cannot send a package directly to an out of state destination. Instead, they must transfer it to a regional facility in the same state that the destination is in. An employee working for that office will then be able to take it to its final destination

For ease of use, we've created many post offices in Texas and populated them with employees and vehicles and local customers. However you can create accounts yourself, but for best results, stay within Texas whenever inputting information for both customers and employees. 

While not doing so won't break anything per say, but you may not get the full experience.

EMPLOYEE CREDENTIALS:

OFFICEID    EMPLOYEEID  PASSWORD
HOU002      1000000     johnMdoe


CUSTOMER CREDENTIALS:
EMAIL                   PASSWORD
cooper@hotmail.com      cooper

INSTRUCTIONS (BACK END):
The back end project is provided, if you look through it, it may seem like a lot, but the following folders are the important bits.

/src/...
    Contains most everything important function wise.
    /Controller/...
        The files in this location live up to their namesakes and control individual pages. However Root_DashboardController.php and Root_HomeController.php contain the majority (if not all) of the SQL queries that the website uses.
/_sql/...
    Contains some sql files but the actual database you would load (if you wished to look at our triggers or anything) would be final_db.sql.