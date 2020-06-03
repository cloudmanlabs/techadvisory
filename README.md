TechAdvisory Platform is a tool built using Laravel and PHP.

It contains three parts, one for Accenture employees, one for Vendors and one for Clients.

# Project sections

Projects have 5 sections full of questions that need to be filled. These are General info, RFP Upload, Sizing Info, Selection Criteria and Invited vendors.

Questions are structured a bit weirdly. For each type of question, there is a model called SomethingQuestion (eg. GeneralInfoQuestion). These inherit from Question, which inherits from Model.

The responses to the question are saved in SomethingQuestionResponse. This model has a relationship to the originalQuestion and to the project. This is done this way so we can reuse questions in different Projects, without having to create them again. I'm not sure if it's the best implementation possible, but it works pretty well. The SomethingQuestionResponse gets attached to the project on Created with the ProjectObserver.

SomethingQuestionResponses are basically pivot models without actually being Pivots.

This same approach is used for all types of questions, including Vendor and Client profile questions.

## General info

These questions are related to the general information of the project, like what Client it belongs to, what Practice, Subpractice, etc.

## RFP Upload

This section only has a File uploader and an extra textarea field for information. Not really sure what use it has.

## Sizing Info

These questions are supposed to be answered by the client. They change according to what Practice has been selected in General Info. The questions also have a checkbox, to choose which ones should be shown to the client. This behavior could be also achieved by removing the question from the project, but they didn't like it this way, so checkboxes it is.

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

## Invited vendors

This is basically a hack, because if we remove this screen the Selection Criteria subwizard stops working correctly. Why? No hecking idea. So we added a screen that looks like it's useful, which displays the list of invited vendors and gives the ability to add and remove them on projectEdit and accenture.newProjectSetUp.

# Users

There are three types of users: Accenture, Clients and Vendors.

## Accenture

Accenture users behave pretty normally, although they have access to the Nova admin panel. They use the default laravel User model.

## Clients and Vendors

Clients and Vendors use the same User model as Accenture, but they use a different way to login. The User modal has many UserCredentials, which are basically alternative email/password combinations to login. This is structured in this horrible way instead of using actual Users for each different credential because the requirement to add extra credentials was added halfway through development.

Basically how it works is that the UserCredentials are used to check if the User can be logged in, and then they log in using the main Client/Vendor account.
