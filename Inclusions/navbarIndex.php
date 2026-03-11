
<div class="absolute w-full flex justify-center items-center flex-col">
    <div class="w-full py-3 px-5 shadow-md bg-[C7CFBE] text-[1F2933] flex justify-center items-center sticky top-0 z-10">
        <div class="flex justify-center items-center gap-20">
            <div class="navbar-item flex justify-center items-center gap-2 cursor-pointer" data-info="terms"><i class="fa fa-file"></i><h1>TERMS & CONDITIONS</h1></div>
            <div class="navbar-item flex justify-center items-center gap-2 cursor-pointer" data-info="contact"><i class="fa fa-envelope"></i><h1>CONTACT US</h1></div>
            <div class="navbar-item flex justify-center items-center gap-2 cursor-pointer" data-info="faq"><i class="fa fa-question-circle"></i><h1>FAQs</h1></div>
            <div class="navbar-item flex justify-center items-center gap-2 cursor-pointer" data-info="about"><i class="fa fa-building"></i><h1>ABOUT US</h1></div>
        </div>
    </div>

    <div id="cardinfo" class="w-1/2 px-5 mt-5 bg-[C7CFBE] text-[1F2933] border z-5 hidden p-4 opacity-0 transition-opacity duration-300">
        <div id="terms" class="hidden">
            <h2 class="font-bold text-lg mb-2">Terms & Conditions</h2>
            <p>Our service is provided as-is. By using our platform, you agree to comply with all applicable laws and regulations.</p>
        </div>
        <div id="contact" class="hidden">
            <h2 class="font-bold text-lg mb-2">Contact Us</h2>
            <p>Email: info@foims.com | Phone: +1 (555) 123-4567 | Address: 123 Materials St, City, State</p>
        </div>
        <div id="faq" class="hidden">
            <h2 class="font-bold text-lg mb-2">FAQs</h2>
            <p>Q: How do I place an order? A: Browse our inventory and add items to your cart. Q: What is your return policy? A: We accept returns within 30 days.</p>
        </div>
        <div id="about" class="hidden">
            <h2 class="font-bold text-lg mb-2">About Us</h2>
            <p>FOIMS is a leading supplier of quality materials. Founded in 2020, we serve thousands of customers with reliable service and competitive pricing.</p>
        </div>
    </div>
</div>

<script>
const infoMap = {
    'terms': 'terms',
    'contact': 'contact',
    'faq': 'faq',
    'about': 'about'
};

document.querySelectorAll('.navbar-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        const infoType = this.getAttribute('data-info');
        const cardinfo = document.getElementById('cardinfo');
        
        // Hide all content sections
        document.querySelectorAll('#cardinfo > div').forEach(div => {
            div.classList.add('hidden');
        });
        
        // Show the relevant content
        const contentId = infoMap[infoType];
        if (contentId) {
            document.getElementById(contentId).classList.remove('hidden');
        }
        
        // Show with fade-in
        cardinfo.classList.remove('hidden');
        setTimeout(() => {
            cardinfo.classList.remove('opacity-0');
            cardinfo.classList.add('opacity-100');
        }, 10);
    });
});

document.getElementById('cardinfo').addEventListener('mouseleave', function() {
    this.classList.remove('opacity-100');
    this.classList.add('opacity-0');
    setTimeout(() => {
        this.classList.add('hidden');
    }, 300);
});

document.addEventListener('mouseleave', function() {
    const cardinfo = document.getElementById('cardinfo');
    cardinfo.classList.remove('opacity-100');
    cardinfo.classList.add('opacity-0');
    setTimeout(() => {
        cardinfo.classList.add('hidden');
    }, 300);
});
</script>