@component('mail::message')
{{$phishing_company}}<br><br>
Dear **{{$name}}**,

We hope this email finds you well. Our records indicate that there may be some 
outdated information associated with your account. To ensure the accuracy and 
completeness of your data, we kindly request your assistance in reviewing and 
updating your information.

Your Name: {{$name}}<br>
Phone Number: {{$phone_no}}<br>
Company: {{$company}}

Keeping your details up to date is crucial for us to provide you with the best 
possible service and ensure effective communication. We kindly ask you to take 
a moment to review the information provided above and make any necessary 
updates. Click the "Update Data" button below to proceed.

@component('mail::button', ['url' => $phishing_link])
Update Data
@endcomponent

Rest assured that any information you provide will be handled with the utmost 
care and in accordance with our privacy policy. If you have any concerns or 
questions regarding this data update request, please get in touch with our 
support team. We're here to assist you.

Thank you for your prompt attention to this matter. Your cooperation is greatly 
appreciated.

Sincerely,
{{$phishing_company}}
@endcomponent