@extends('acc::layouts.app')

@section('content')
    <p class="clearfix"></p>

    <div class="card">
        <div class="card-body">
            <h1 class="text-center mb-4">Privacy Policy</h1>

            <p>Welcome to MakeFreeInvoice! Your privacy is important to us. This Privacy Policy explains how we collect, use, and safeguard your information when you use our platform. By accessing or using MakeFreeInvoice, you agree to the terms outlined in this policy. If you do not agree, please refrain from using our services.</p>

            <h4>1. Information We Collect</h4>
            <p>We may collect the following types of information when you use MakeFreeInvoice:</p>
            <ul>
                <li><strong>Personal Information:</strong> Name, email address, and account details provided during registration.</li>
                <li><strong>Usage Data:</strong> Information about your interactions with the platform, including pages visited, features used, and time spent on the application.</li>
                <li><strong>Device Information:</strong> IP address, browser type, operating system, and device identifiers.</li>
            </ul>

            <h4>2. How We Use Your Information</h4>
            <p>Your information is used to:</p>
            <ul>
                <li>Provide and improve our services.</li>
                <li>Communicate with you about your account or transactions.</li>
                <li>Send updates, promotional offers, or service-related announcements (with your consent).</li>
                <li>Monitor and analyze platform usage to improve functionality and user experience.</li>
            </ul>

            <h4>3. Sharing Your Information</h4>
            <p>We do not sell or share your personal information with third parties, except in the following circumstances:</p>
            <ul>
                <li>When required by law or legal processes.</li>
                <li>To protect the rights, property, or safety of MakeFreeInvoice, our users, or others.</li>
                <li>With trusted third-party service providers who assist us in delivering our services, subject to confidentiality agreements.</li>
            </ul>

            <h4>4. Data Security</h4>
            <p>We implement industry-standard measures to protect your information from unauthorized access, loss, or misuse. However, no online platform can guarantee complete security. Please use the platform responsibly.</p>

            <h4>5. Cookies and Tracking</h4>
            <p>We use cookies and similar technologies to enhance your experience. You can manage or disable cookies through your browser settings. Note that disabling cookies may affect certain functionalities of the platform.</p>

            <h4>6. Your Rights</h4>
            <p>You have the right to:</p>
            <ul>
                <li>Access, update, or delete your personal information.</li>
                <li>Withdraw consent for data usage where applicable.</li>
                <li>Contact us for questions or concerns regarding your privacy.</li>
            </ul>

            <h4>7. Changes to This Policy</h4>
            <p>We may update this Privacy Policy periodically to reflect changes in our practices or applicable laws. The latest version will always be available on our platform. Your continued use of the platform signifies acceptance of any updates.</p>

            <h4>8. Premium Features and Privacy</h4>
            <p>While the "Create Invoice" feature is free and collects minimal data, premium features may require additional data for billing, support, or enhanced functionalities. Details regarding data usage for premium features will be provided separately.</p>

            <p>If you have any questions or concerns about this Privacy Policy, please contact us at support@makefreeinvoice.com.</p>

            <p class="text-muted text-center mt-4">Last Updated: {{ now()->format('F d, Y') }}</p>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .card-body {
            line-height: 1.6;
            font-size: 1rem;
        }

        h4 {
            margin-top: 1.5em;
        }

        ul {
            margin-left: 1.5em;
            list-style: disc;
        }
    </style>
@endsection
