<x-layouts.storefront :dark="true" title="Privacy Policy">
    <section class="page-head relative isolate overflow-hidden bg-ink-900 text-[#ece7da]">
        <img src="{{ asset('images/luxury-garage-commission.jpg') }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-80 brightness-105" aria-hidden="true">
        <div class="absolute inset-0 -z-10 bg-[linear-gradient(95deg,rgba(11,11,13,0.94)_0%,rgba(11,11,13,0.65)_50%,rgba(11,11,13,0.3)_100%)]"></div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-ink-900 to-transparent"></div>
        <div class="mx-auto max-w-[88rem] px-5 py-24 sm:px-8 sm:py-28 lg:px-12">
            <div class="flex items-center gap-4">
                <span class="rule-gold"></span>
                <p class="label text-gold-500">Legal</p>
            </div>
            <h1 class="mt-8 font-lux text-[clamp(2.8rem,6vw,5.2rem)] font-normal leading-[1] tracking-[-0.015em]">Privacy <em class="font-normal italic text-gold-300">policy.</em></h1>
            <p class="mt-7 max-w-lg font-label text-[1.02rem] font-light leading-relaxed text-[#cfcabd]">Last updated: {{ now()->format('F j, Y') }}</p>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 prose-sm">
        <div class="space-y-10 text-[#d3cec1] leading-relaxed">
            <p class="text-[#8f949c] italic">
                At JDM Custom Creations, your privacy is a top priority. This Privacy Policy outlines how we collect,
                use, and protect your personal information when you visit our website or interact with our services. By
                using our website, you agree to the practices described in this policy.
            </p>

            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">1. Information We Collect</h2>
                <p>
                    We collect information you provide to us directly, such as your name, email address, phone number,
                    and any details you share when submitting forms or placing orders. Additionally, we may gather
                    information automatically, such as your IP address, browser type, and usage data, to improve your
                    experience on our website.
                </p>
            </div>

            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">2. How We Use Your Information</h2>
                <p>
                    The information we collect is used to process your orders, respond to your inquiries, and provide
                    personalized customer service. We may also use your data to improve our website, send updates about
                    our products and services, and for internal analytics purposes.
                </p>
            </div>
            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">3. Sharing Your Information</h2>
                <p>
                    We value your trust and do not sell, trade, or share your personal information with third parties
                    except as necessary to fulfill your orders or comply with legal obligations. In some cases, we may
                    work with trusted service providers who help us operate our website or deliver services, and they
                    are required to keep your information confidential.
                </p>
            </div>
            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">4. Data Security</h2>
                <p>
                    We implement industry-standard security measures to protect your personal information from
                    unauthorized access, alteration, or disclosure. While we strive to safeguard your data, no method of
                    transmission or storage is entirely secure, and we cannot guarantee absolute security.
                </p>
            </div>
            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">5. Your Rights</h2>
                <p>
                    You have the right to access, correct, or delete the personal information we hold about you. If you
                    wish to exercise these rights, please contact us directly. Additionally, you may choose to opt-out
                    of receiving promotional emails by following the unsubscribe instructions in our messages.
                </p>
            </div>

            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">6. Cookies and Tracking Technologies
                </h2>
                <p>
                    Our website uses cookies and similar technologies to enhance your browsing experience, analyze site
                    traffic, and understand user preferences. You can manage your cookie preferences through your
                    browser settings.
                </p>
            </div>


            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">7. Policy Updates</h2>
                <p>
                    We may update this Privacy Policy from time to time to reflect changes in our practices or legal
                    requirements. Any updates will be posted on this page, and we encourage you to review it
                    periodically.
                </p>
            </div>

            <div>
                <h2 class="font-lux text-lg font-normal text-[#ece7da] mb-3">8. Contact</h2>
                <p>
                    If you have any questions about this Privacy Policy or how we handle your personal information,
                    please contact us at:
                    <br>
                    Email: <a href="mailto:jdmadvancedbuilders@gmail.com" class="text-gold-400 hover:underline">jdmadvancedbuilders@gmail.com</a>
                    <br>
                    Phone: <a href="tel:+1234567890" class="text-gold-400 hover:underline">+1 (234) 567-890</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.storefront>