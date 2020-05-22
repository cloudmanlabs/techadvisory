TechAdvisory Platform is a tool built using Laravel and PHP.

It contains three parts, one for Accenture employees, one for Vendors and one for Clients.

## Selection Criteria

Selection criteria questions are the ones that the vendor is supposed to answer.

This should only be reviewed by the client, as they're only answered by the vendors in the project.

### Fitgap

    Fitgap is a spreadsheet that forms part of the Selection Criteria questions.

    In total it has 10 columns: Requirement Type, Level 1, Level 2, Level 3, Requirement, Client, Business Opportunity, Vendor Response, Comment, Score.

    There are three sides to the fitgap:
        Accenture / client see the first 5 and Client, Business Opportunity on newProjectSetup
            Only the last are editable through the excel
            The first 5 need to be uploaded

        Vendor / Accenture in vendor support see the first 5 and Vendor Response, Comment
            Only last 2 are editable

        Accenture in vendor evaluation sees the first 5, Vendor Response, Comment and Score
            Only score col is editable

# Users

There are three types of users: Accenture, Clients and Vendors.

## Accenture

Accenture users behave pretty normally, although they have access to the Nova admin panel. They use the default laravel User model.

## Clients and Vendors

Clients and Vendors use the same User model as Accenture, but they use a different way to login. The User modal has many UserCredentials, which are basically alternative email/password combinations to login. This is structured in this horrible way instead of using actual Users for each different credential because the requirement to add extra credentials was added halfway through development.

Basically how it works is that the UserCredentials are used to check if the User can be logged in, and then they log in using the main Client/Vendor account.
