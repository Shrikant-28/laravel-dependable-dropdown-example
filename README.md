<p>1. Configure the .env file</p>

<p>2. For Gmail Configuration Set Below parameter:<p>
    <ul>
        <li>MAIL_MAILER=smtp</li>
        <li>MAIL_HOST=smtp.gmail.com</li>
        <li>MAIL_PORT=587</li>
        <li>MAIL_USERNAME=xxxxxxxxx@gmail.com</li>
        <li>MAIL_PASSWORD=xxxxxxxxxxxxx</li>
        <li>MAIL_ENCRYPTION=tls</li>
        <li>MAIL_FROM_ADDRESS=xxxxxxxxxx@gmail.com</li>
        <li>MAIL_FROM_NAME="${APP_NAME}"</li>
     </ul>
    
3. 
<pre>
$ composer update
Run <b>DB_Script/sar_dump.sql</b> file
$ php artisan serve
</pre>

<p>4. Result</p>
<ul>
    <li>You will receive an email after configuring the above parameter.</li>
</ul>
<img src="https://user-images.githubusercontent.com/59720723/143690024-1bf44b43-fb09-4d47-bdac-d8aab8a1b6e3.png" />

![image](https://user-images.githubusercontent.com/59720723/143814502-c810f80b-c2bb-4ca6-8e24-0ae9448db367.png)



 
