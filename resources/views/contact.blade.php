<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Header --}}
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Contact Us</h1>
                <p class="text-[#A0A0A0] text-lg max-w-2xl mx-auto">We're here to help. Reach out to our team for any questions or support.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                {{-- Contact Form --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-6" style="font-family: 'Playfair Display';">Send us a Message</h2>
                    
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-[#A0A0A0] mb-2">Your Name</label>
                                <input type="text" name="name" required class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-lg px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-sm text-[#A0A0A0] mb-2">Email Address</label>
                                <input type="email" name="email" required class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-lg px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" placeholder="john@example.com">
                            </div>
                            <div>
                                <label class="block text-sm text-[#A0A0A0] mb-2">Subject</label>
                                <select name="subject" required class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-lg px-4 py-3 text-white focus:border-[#D4AF37] focus:outline-none transition-colors">
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="support">Account Support</option>
                                    <option value="deposit">Deposit/Withdrawal</option>
                                    <option value="order">Order Question</option>
                                    <option value="kyc">KYC Verification</option>
                                    <option value="business">Business Partnership</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-[#A0A0A0] mb-2">Message</label>
                                <textarea name="message" rows="5" required class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-lg px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors resize-none" placeholder="How can we help you?"></textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full">Send Message</button>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="mt-4 p-4 bg-green-500/20 border border-green-500/30 rounded-lg text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                {{-- Contact Info --}}
                <div class="space-y-8">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-6" style="font-family: 'Playfair Display';">Get in Touch</h2>
                        <p class="text-[#A0A0A0] mb-6">Our support team is available Monday to Friday, 9AM to 6PM EST. We typically respond within 24 hours.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold mb-1">Email</h3>
                                <p class="text-[#A0A0A0] text-sm">support@goldbrokers.io</p>
                                <p class="text-[#666] text-xs mt-1">For general inquiries</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold mb-1">Phone</h3>
                                <p class="text-[#A0A0A0] text-sm">+1 (888) 555-GOLD</p>
                                <p class="text-[#666] text-xs mt-1">Mon-Fri, 9AM-6PM EST</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold mb-1">Headquarters</h3>
                                <p class="text-[#A0A0A0] text-sm">350 Fifth Avenue, Suite 7500</p>
                                <p class="text-[#A0A0A0] text-sm">New York, NY 10118</p>
                                <p class="text-[#666] text-xs mt-1">United States</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold mb-1">Business Hours</h3>
                                <p class="text-[#A0A0A0] text-sm">Monday - Friday: 9AM - 6PM EST</p>
                                <p class="text-[#A0A0A0] text-sm">Saturday - Sunday: Closed</p>
                            </div>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="pt-6 border-t border-[#D4AF37]/20">
                        <h3 class="text-white font-semibold mb-4">Follow Us</h3>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center hover:bg-[#D4AF37]/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center hover:bg-[#D4AF37]/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center hover:bg-[#D4AF37]/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center hover:bg-[#D4AF37]/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- Footer --}}
<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20 py-6">
    <div class="section-container">
        <div class="section-inner flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldVault. All rights reserved.</div>
            <div class="flex items-center gap-6">
                <a href="{{ route('about') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">About</a>
                <a href="{{ route('contact') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Contact</a>
                <a href="{{ route('faq') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">FAQ</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
