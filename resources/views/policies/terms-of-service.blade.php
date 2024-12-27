@extends('acc::layouts.app')

@section('content')
    <p class="clearfix"></p>

    <div class="card">
        <div class="card-body">
            <h1 class="text-center mb-4">Terms of Service</h1>

            <p>Welcome to MakeFreeInvoice! By accessing or using our platform, you agree to comply with and be bound by the following terms and conditions of use, which govern the relationship between you and MakeFreeInvoice. If you do not agree to these terms, please refrain from using our services.</p>

            <h4>1. Acceptance of Terms</h4>
            <p>Your use of the MakeFreeInvoice application signifies your agreement to these terms of service. These terms may be updated occasionally, and it is your responsibility to review them periodically.</p>

            <h4>2. Use of the Application</h4>
            <p>You agree to use MakeFreeInvoice only for lawful purposes and in accordance with applicable laws and regulations. Unauthorized use of the platform, including but not limited to hacking, spamming, or distributing malicious content, is strictly prohibited.</p>

            <h4>3. Intellectual Property</h4>
            <p>All content, trademarks, and other intellectual property available on MakeFreeInvoice are owned by the company or licensed for use. You may not reproduce, distribute, or exploit any material without prior written consent.</p>

            <h4>4. Privacy</h4>
            <p>Your privacy is important to us. Please review our Privacy Policy to understand how we collect, use, and safeguard your information.</p>

            <h4>5. Limitations of Liability</h4>
            <p>MakeFreeInvoice is provided on an "as is" basis. We do not guarantee uninterrupted or error-free service. The company shall not be liable for any damages resulting from the use or inability to use the application.</p>

            <h4>6. Account Responsibility</h4>
            <p>You are responsible for maintaining the confidentiality of your account information, including your username and password. Notify us immediately of any unauthorized use of your account.</p>

            <h4>7. Premium Features</h4>
            <p>Please note that while the "Create Invoice" feature is free forever, other features available on MakeFreeInvoice will require a premium subscription. These premium features will be clearly marked, and details regarding pricing and terms of use will be provided separately.</p>

            <h4>8. Termination</h4>
            <p>We reserve the right to suspend or terminate your account if we detect any violation of these terms or suspicious activity.</p>

            <h4>9. Governing Law</h4>
            <p>These terms of service shall be governed by and construed in accordance with the laws of the jurisdiction where MakeFreeInvoice operates.</p>

            <p>If you have any questions about these terms, please contact us at support@makefreeinvoice.com.</p>

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
    </style>
@endsection
