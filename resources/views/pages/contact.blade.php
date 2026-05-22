@extends('layouts.app')

@section('title', 'Contact Us - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-6 max-w-7xl mx-auto w-full">
        <div class="text-center mb-16 reveal" data-reveal="up">
            <h1 class="text-5xl font-bold mb-4 tracking-tight text-dark-chocolate">Contact <span class="text-sakura">CosRent</span></h1>
            <p class="text-dark-chocolate/80 text-lg max-w-2xl mx-auto font-medium">Have questions about costume rentals, vendor partnerships, or need help? The CosRent team is ready to assist you!</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">

            <div class="space-y-6">
                <div class="glass-card p-8 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl reveal delay-100" data-reveal="left">
                    <h3 class="text-2xl font-bold text-dark-chocolate mb-6">CosRent Support Team</h3>
                    <p class="text-sm text-dark-chocolate/70 font-medium mb-6">Contact one of our admins below for a faster response via WhatsApp.</p>

                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Crist Garcia Pasaribu</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 896-2346-7477</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Rangga Surya Saputra</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 812-6126-0195</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Akbar Zamroni</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 811-7092-501</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-dark-chocolate text-misty-rose p-8 rounded-[2rem] shadow-xl border-2 border-dark-chocolate reveal delay-200" data-reveal="left">
                    <h3 class="text-xl font-bold mb-3 text-sakura"><i class="fa-solid fa-clock mr-2"></i>Service Hours</h3>
                    <p class="text-misty-rose/80 text-sm leading-relaxed">
                        Our team is available from <span class="font-bold text-white">Monday - Friday</span> at <span class="font-bold text-white">09:00 - 17:00 WIB</span>. Messages received outside working hours will be replied to on the next business day.
                    </p>
                </div>
            </div>

            <div class="glass-card p-8 md:p-10 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl h-fit reveal delay-300" data-reveal="right">
                <h3 class="text-2xl font-bold text-dark-chocolate mb-2">Send a Message</h3>
                <p class="text-sm text-dark-chocolate/70 font-medium mb-8">Fill out the form below and your message will be forwarded to our email.</p>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block mb-1 text-sm font-bold text-dark-chocolate">Full Name</label>
                            <input type="text" class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium" placeholder="Enter your name">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-bold text-dark-chocolate">Active Email</label>
                            <input type="email" class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium" placeholder="example@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-bold text-dark-chocolate">Question Subject</label>
                        <select class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium">
                            <option value="">-- Choose Topic --</option>
                            <option value="sewa">Costume Rental</option>
                            <option value="vendor">Vendor Partnership</option>
                            <option value="teknis">Technical Help / Error</option>
                            <option value="lainnya">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-bold text-dark-chocolate">Your Message</label>
                        <textarea rows="5" class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium resize-none" placeholder="Write your question or concern in detail here..."></textarea>
                    </div>

                    <button type="button" class="w-full bg-dark-chocolate hover:bg-black text-misty-rose font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex justify-center items-center gap-2 mt-4">
                        <span>Send Message Now</span>
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </form>
            </div>

        </div>
    </main>
@endsection
