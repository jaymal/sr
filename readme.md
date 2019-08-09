-  I am assuming 'unavailable'  means we already know that the service is not available and not a run time discovery. 

- I wrote a custom implementation of Laravel mailer class called the TakeawayMailer and made it extend the laravel mailer class.It does nothing other than just extend it because base class has a lot of useful dependencies

- I then did a override of the default implementation of Mailer in Illuminate\Mail\MailServiceProvider by creating a new service provider called TakeawayMailProvider where different custom transport managers[mailjet & sendgrid] can also added

- I chose to make sending the mail and an event-driven action just incase there'a later decison to send some other kind of mails/notifications

- I used Docker Toolbox  and my IP designations are as follows

  - http://192.168.99.100:80/sendMail - Service used for sending the emails
  - http://192.168.99.100:80/show - Service used for retrieving email logs
  - http://192.168.99.100:5000/  -- Vue app using the service above and displaying the log table