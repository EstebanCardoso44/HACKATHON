import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.mime.application import MIMEApplication

def send_email(sender_email, recipient_email, subject, message, attachment_path=None):
    # Gmail SMTP
    smtp_server = 'smtp.gmail.com'
    smtp_port = 587  # TLS port

    # credentials
    gmail_username = 'tongmail'
    gmail_password = 'tonmdpgmail'

    # Create the email
    msg = MIMEMultipart()
    msg['From'] = sender_email
    msg['To'] = recipient_email
    msg['Subject'] = subject

    msg.attach(MIMEText(message, 'plain'))

    if attachment_path:
        with open(attachment_path, 'rb') as attachment:
            part = MIMEApplication(attachment.read(), Name='attachment.pdf')
        part['Content-Disposition'] = 'attachment; filename={}'.format(attachment_path)
        msg.attach(part)

    try:
        server = smtplib.SMTP(smtp_server, smtp_port)
        server.starttls()
        server.login(gmail_username, gmail_password)

        server.sendmail(sender_email, recipient_email, msg.as_string())

        print("Email sent successfully")

    except Exception as e:
        print("Error: " + str(e))

    finally:
        server.quit()

#func
send_email('estebancardoso44@gmail.com', 'esteban.cardoso@ynov.com', 'Sujet de votre email', 'Ceci est le message de votre email')
