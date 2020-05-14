TechAdvisory Platform is a tool built using Laravel and PHP.

It contains three parts, one for Accenture employees, one for Vendors and one for Clients.

## Selection Criteria

Selection criteria questions are the ones that the vendor is supposed to answer.

This should only be reviewed by the client, as they're only answered by the vendors in the project.

### Fitgap

    Fitgap is a spreadsheet that forms part of the Selection Criteria questions.

    In total it has 10 columns: Requirement Type, Level 1, Level 2, Level 3, Requirement, Client, Business Oportunity, Vendor Response, Comment, Score.

    There are three sides to the fitgap:
        Accenture / client see the first 5 and Client, Business Oportunity on newProjectSetup
            Only the last are editable through the excel
            The first 5 need to be uploaded

        Vendor / Accenture in vendor support see the first 5 and Vendor Response, Comment
            Only last 2 are editable

        Accenture in vendor evaluation sees the first 5, Vendor Response, Comment and Score
            Only score col is editable
