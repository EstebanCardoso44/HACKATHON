import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.mime.application import MIMEApplication
import requests
import re
import os
import subprocess


def create_pivpn_user(username):
    subprocess.run(["pivpn", "add", "--name", username], check=True)
    print(f"User {username} created successfully")


def extract_emails(data):
    email_pattern = r"\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,7}\b"
    extracted_emails = []

    for item in data:
        for key, value in item.items():
            matches = re.findall(email_pattern, value)
            for match in matches:
                extracted_emails.append(match)

    return extracted_emails


def add_api():
    config = {
        "user": "id21350906_root",
        "password": "root49*A",
        "host": "localhost",
        "database": "id21350906_hackathon",
    }
    url_de_l_api = "https://ypn666.000webhostapp.com/HACKATHON/function/api.php"
    r = requests.get(url_de_l_api)
    data = r.json()
    extracted_emails = extract_emails(data)
    print(extracted_emails)

    # Define the folder path
    folder_path = "configs"

    # List all files in the folder
    files = os.listdir(folder_path)
    for name in extracted_emails:

        # Iterate through each file name in the folder
        file_names = [file_name[:-5].lower() for file_name in files]
        # Compare the name with the file name (case-insensitive)
        if name.lower() in file_names:
            print("IN IF ")
            print(f"{name}")
            print(f"{file_names}")
            print("OUT IF ")
            # Exit the inner loop if a match is found
        else:
            print("in else")
            print(f"{name}")
            print(f"{file_names}")
            print("else")
            create_pivpn_user(name)
            send_email(gmail_username, name, 'VPN Configuration', "Votre fichier de configuration se trouve en PJ. Veuiliez l'importer dans WireGuard pour crée initialiser la connexion")


def send_email(sender_email, recipient_email, subject, message, attachment_path="configs"):
    # Gmail SMTP
    smtp_server = "smtp.gmail.com"
    smtp_port = 587  # TLS port

    # credentials
    gmail_username = "hackathonynov@gmail.com"
    gmail_password = "gjnfrrzjdqyvltjj"

    # Create the email
    msg = MIMEMultipart()
    msg["From"] = sender_email
    msg["To"] = recipient_email
    msg["Subject"] = subject

    msg.attach(MIMEText(message, "plain"))

    if attachment_path:
        with open(attachment_path, "rb") as attachment:
            part = MIMEApplication(attachment.read(), Name=f"{recipient_email}.conf")
        part["Content-Disposition"] = "attachment; filename={}".format(attachment_path)
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


# func
gmail_username = "hackathonynov@gmail.com"
add_api()

