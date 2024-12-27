@extends('acc::layouts.app')

@section('content')
    <p class="clearfix"></p>

    <div class="card">
        <div class="card-body">
            <h1 class="text-center mb-4">User Data Deletion</h1>

            <p>At MakeFreeInvoice, we value your privacy and are committed to protecting your personal information. This page outlines the process for requesting the deletion of your user data from our platform in compliance with applicable data protection regulations.</p>

            <h4>1. Data Deletion Rights</h4>
            <p>As a user, you have the right to request the deletion of your personal data stored with us. Upon successful verification of your request, we will permanently delete your data unless it is required for legal, contractual, or security purposes.</p>

            <h4>2. How to Request Data Deletion</h4>
            <ol>
                <li>Send an email to our support team at <a href="mailto:support@makefreeinvoice.com">support@makefreeinvoice.com</a> with the subject line "User Data Deletion Request".</li>
                <li>Include the following information in your email:
                    <ul>
                        <li>Your registered email address or username.</li>
                        <li>A brief statement confirming your request for data deletion.</li>
                    </ul>
                </li>
                <li>Once we receive your request, we will verify your identity to ensure the security of your data.</li>
            </ol>

            <h4>3. Data Deletion Process</h4>
            <p>After successful verification, we will:
                <ul>
                    <li>Remove all personally identifiable information associated with your account.</li>
                    <li>Delete any content you have created, unless required for legal or compliance reasons.</li>
                    <li>Confirm the completion of the deletion process via email.</li>
                </ul>
            </p>

            <h4>4. Exceptions to Data Deletion</h4>
            <p>In certain cases, we may be unable to delete specific data due to legal, regulatory, or contractual obligations. If this applies to your request, we will notify you and provide an explanation.</p>

            <h4>5. Retention of Anonymized Data</h4>
            <p>While your personal data will be deleted, we may retain anonymized, non-identifiable data for analytics and operational purposes. This data cannot be traced back to you as an individual.</p>

            <h4>6. Contact Us</h4>
            <p>If you have any questions or concerns regarding the data deletion process, feel free to reach out to us at <a href="mailto:support@makefreeinvoice.com">support@makefreeinvoice.com</a>.</p>

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
