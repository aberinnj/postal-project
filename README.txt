Welcome to Group 1's (Tuesday/Thursday) postal office project!
This document contains 3 important sections, that is the IMPORTANT, the INSTRUCTIONS and the CREDENTIALS. There are also some backend information should they matter. If you have any questions feel free to email our group leader.
---------------------
IMPORTANT:
There's a couple of things to keep in mind before using this project that might be confusing if you aren't aware of them but actually help immensely with keeping the data organized and relevant to those logged in.

1. There are a series of "offices" associated with certain states. However not every state has an office. This is important.

2. Each employee works for an office. When an employee logs in they will see package information relating to only to that office (except in the reports) which they choose when they register; in other words they will not see packages sent to other offices, and so won't be able to manage and deliver those packages, only packages sent to their office.

3. When a customer creates a package, they have to specify their address, including the state they reside in. Likewise, they also have to specify which nearby office they want to drop their package off at to send it to its final destination for them. So a customer in Texas can drop off their packages to offices in Texas.

4. An employee CAN do interstate shipments, however they cannot send a package directly to an out of state destination. Instead, they must transfer it to a REGIONAL facility in the same state that the destination is in. An employee working for that office will then be able to take it to its final destination

For ease of use, we've created many post offices in Texas and populated them with employees and vehicles and local customers. However you feel free to make accounts for other offices elsewhere. The results may not be as densely populated, however.

Not doing so won't break anything, of course, however the experience is a bit lengthier (as it should be), so just keep this in mind.
---------------------

INSTRUCTIONS (FRONT END):
The site is, for the most part, pretty intuitive. But just in case, here's a general guide to the standard and expected usage.

    HOME PAGE:
        This page contains 3 basic important functions. 
        
        1. The first and foremost is the central tracking box. This is where you can insert any (existing) package number and get its tracking details. When you create a package, you will be given a number to use for tracking.

        2. The "My Account" button in the top right corner is where you log in as a customer or register. There are provided credentials at the bottom of this document, but you can register all the same.

        3. Scroll all the way to the bottom and find two links, "Careers" and "Employee Portal", which act as an employee registration and employee log in respectively. Likewise, there are employee credentials provided, but you can make an account all the same. When you do, you will be given an employee ID. Keep note or copy this number.

    CUSTOMER:
        The page you get when you log in as a customer is the dashboard and will give general/pertinent information on the packages associated with that user. There are 3 links in the top navbar.

        1. My Orders: Gives a list of all of your packages and the option to view their tracking and/or invoice information.

        2. Packages->Create a Package: A simple page where you can input your details and details of the receiving address and that of the package. As mentioned in the IMPORTANT section, be aware of the implications of selecting an out of state receiving address (State). Also keep in mind that there are variable limits for weight and length etc.
            2.1 After making the package, there's a "next" button that will take you to select the office you want to drop your package off at. You can only select an office in your state, only "regional" offices can send packages to offices out of state. The office itself (as an employee) can transfer packages to a regional offices to send it out of state. A customer doesn't need to worry about it.

        3. Packages-> Track a Package: This takes you to a page where you can input a specific package number and get tracking information, similar to the one on the home page.

        And that's it! Pretty simple. Just sit back and relax as the package is delivered... by you.

    EMPLOYEE:
        The page you get when you log in as an employee is the dashboard and will simply tell you your ID and the office you work in. The important 3 buttons are in the nav bar. (There is a "My Office" button but that leads to an empty page).

        1. Manage Office: This page gives a table list of packages in the offices and information on them. The pertinent parts are the Office Vehicles selections and the "Load Button"
            1.1 Office Vehicles: A drop down to select which vehicle you - the employee - wish to load a particular package into. 

            1.2 Load: Loads the package into the vehicle. Assigns a vehicle id to the package in the backend.

        2. My Delivery: Once you've loaded your packages into a vehicle, click this link. 
            2.1 You'll have a similar vehicle selection drop down. Simply select your vehicle and click "select vehicle" (preferably the same vehicle you selected in the previous page) and you'll be given the list of packages loaded into that vehicle and be given the option to start your shift.

            2.2 Once you start your shift, each package in your vehicle will have a button to view package details but, more importantly, the option to actually deliver the package to a location. This is where the magic happens.
                2.2.1 Click the drop down menu. If your office is in the same state as the package's destination state, then you can send it directly to the destination.

                2.2.2 If your office is out of state, then you can send it to a regional office, and it's no longer your problem! This will place the package in a separate office. 

                2.2.3 You wont be able to view this package in the office anymore, however an employee associated with that regional office that logs in will and can pick it up and send it to an office in the destination state (but not the destination itself).

                2.2.4 Once you've managed all your packages, end your shift and you're basically done! If you want to continue delivering packages to their final destination that have been sent to regional or other offices, log out and sign in to an account (or make one!) associated with that office and finish the job.

                2.2.5 One last note, the time between you starting and ending your shift is recorded in real time (no simulation adjustments) so in the reports, where your hours worked is displayed, the hours might be low or 0 since deliveries can be "made" quickly.

            3. Actions -> View Courier.PO Reports: This page basically displays about 4 reports. There are index links for your convenience to send you up and down the page to the relevant reports.

            And that's it for employees! It's pretty simple if you create in state packages and can send them directly to their destinations, but doing otherwise is very much possible, it just becomes a game of logging out and then into other accounts to pick up packages. So feel free to check if that works!
        
    And that's the whole site, basically. Once you've delivered your packages to other offices or the destination, check out the tracking numbers (or log back in as a customer and view their dashboard) to check status and tracking information of the packages. Pretty cool!

---------------------
EMPLOYEE CREDENTIALS:

OFFICEID    EMPLOYEEID  PASSWORD
HOU002      1000000     johnMdoe
AUS001      1000005     pass


CUSTOMER CREDENTIALS:
EMAIL                   PASSWORD
cooper@hotmail.com      cooper

INSTRUCTIONS (BACK END):
The back end project is provided, if you look through it, it may seem like a lot, but the following folders are the important bits.

/_sql/...
    Contains some sql files but the actual database you would load (if you wished to look at our triggers or anything) would be final_db.sql.

/src/...
    Contains most everything important function wise.
    /Controller/...
        The files in this location live up to their namesakes and control individual pages. However Root_DashboardController.php and Root_HomeController.php contain the majority (if not all) of the SQL queries that the website uses.
