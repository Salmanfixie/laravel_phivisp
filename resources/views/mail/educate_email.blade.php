@component('mail::message')
Dear **{{$name}}**,

We hope this email finds you well. We would like to bring to your attention an 
important matter regarding the security of your account with {{$phishing_company}}. 
As part of our ongoing efforts to protect your personal information, we recently 
conducted a phishing simulation exercise.

Phishing is a fraudulent practice used by malicious individuals to trick unsuspecting 
individuals into revealing sensitive information, such as passwords or financial 
details, through deceptive emails or websites. The purpose of our simulation exercise 
was to raise awareness about phishing and educate our valued customers, like you, on 
how to identify and avoid falling victim to such scams.

Please be informed that the email you received earlier, titled "{{$phishing_email_subject}}" 
was part of this phishing simulation exercise. We intentionally designed the email 
to resemble a typical phishing email to help you recognize the warning signs. We 
apologize for any confusion or inconvenience this may have caused you.

We take your security and privacy seriously, and we encourage you to remain vigilant 
when interacting with emails or websites that request personal information. To learn 
more about how to identify and protect yourself from phishing attempts, we have 
prepared some valuable resources:
 
[Phishing Awareness Guide](https://www.cyberriskaware.com/protect-against-phishing-attacks-guide/)<br>
[Tips to Identify Phishing Emails](https://cofense.com/knowledge-center/how-to-spot-phishing/)<br>
[Protecting Your Online Security](https://www.nytimes.com/guides/privacy-project/how-to-protect-your-digital-privacy)

Your feedback is important to us, and we would appreciate it if you could take a few 
moments to share your thoughts and experiences regarding this phishing simulation 
exercise. Your feedback will help us enhance our security measures and better educate 
our customers. 

Please click the link below to access the feedback form.<br>
[Feedback Form]({{ $feedback_link }})

Rest assured that your personal information is secure, and your account has not 
been compromised. We are committed to providing you with a safe and reliable 
banking experience.

If you have any further questions or concerns, please do not hesitate to reach 
out to our dedicated support team. We are here to assist you. Thank you for 
your understanding and cooperation in this matter. Together, we can combat 
phishing attempts and protect your financial well-being.

Sincerely,
{{$phishing_company}}
@endcomponent