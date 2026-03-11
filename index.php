<?php
    session_start();
?>
<body class="bg-[#D0DACA] text-[#1F2933]">

    <!--Important import files-->
    <?php
        include __DIR__ ."/Inclusions/Head.php";
        include __DIR__ ."/Inclusions/Methods.php";
    ?>
    
    <nav class="flex items-center justify-between px-6 md:px-20 py-5 bg-[#D0DACA] border-b border-[#1F2933]/10">
        <div class="flex items-center space-x-1">
            <img class="h-10 w-10" src="./Assets/Icons/MaterialsCo_Logo.svg" alt="FOIMS logo">
            <span class="text-2xl font-bold text-[#1F2933]">FOIMS</span>
        </div>
        <div class="hidden md:flex space-x-8 font-medium">
            <a href="#Home" class="hover:opacity-70">Home</a>
            <a href="#Features" class="hover:opacity-70">Features</a>
            <a href="#Community" class="hover:opacity-70">Community</a>
            <a href="#Demo" class="hover:opacity-70">Demo</a>
        </div>
        <button id="openAuthPanel" class="bg-[#1F2933] text-[#D0DACA] px-6 py-2 rounded-md hover:opacity-90 transition font-semibold cursor-pointer">
            Register Now
        </button>
    </nav>

    <!--SignIn and SignUp panel-->
    <div id="authPanel" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-sm pointer-events-none p-4">
        <div class="pointer-events-auto w-full max-w-md">

            <div id="SignInForm" class="hidden rounded-xl shadow-2xl bg-[#C7CFBE] text-[#1F2933] flex flex-col items-center text-center p-8 sm:p-10 gap-3 border border-[#1F2933]/20 animate-fadeIn">
                <h1 class="text-3xl font-bold mb-4">Welcome Back!</h1>
                
                <?php flashError('Logmessage'); ?>
                
                <form class="text-start w-full space-y-4" action="./Process/Authentecation.php" method="POST">
                    <div>
                        <label class="block text-sm font-bold uppercase tracking-wider mb-1">Email</label>
                        <input class="border border-[#1F2933]/30 rounded-md w-full h-12 p-3 bg-[#D0DACA]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F2933] transition-all" type="email" name="email" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold uppercase tracking-wider mb-1">Password</label>
                        <input class="border border-[#1F2933]/30 rounded-md w-full h-12 p-3 bg-[#D0DACA]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F2933] transition-all" type="password" name="password" required>
                    </div>
                    
                    <div class="flex flex-row gap-2 mt-4">
                        <input name="signIn" class="w-full h-12 bg-[#1F2933] text-[#D0DACA] rounded-md font-bold cursor-pointer hover:opacity-90 transition-all shadow-md active:scale-[0.98]" type="submit" value="Sign In">
                        
                        <button type="button" onclick="document.getElementById('authPanel').classList.add('hidden')" class="w-full h-12 border-2 border-[#1F2933] text-[#1F2933] rounded-md font-bold hover:bg-[#1F2933] hover:text-[#D0DACA] transition-all duration-200">
                            Cancel
                        </button>
                    </div>
                </form>
                
                <p class="mt-4 text-sm opacity-80">
                    Doesn't have an account yet? 
                    <button id="showSignUp" class="text-[#1F2933] font-bold hover:opacity-70 cursor-pointer">Create Now!</button>
                </p>
            </div>

            <div id="SignUpForm" class="rounded-xl shadow-2xl bg-[#C7CFBE] text-[#1F2933] flex flex-col items-center text-center p-8 sm:p-10 space-y-5 border border-[#1F2933]/20 animate-fadeIn">
                <h1 class="text-3xl font-bold">Glad to Have You!</h1>

                <?php 
                    flashError('LogmessageReg'); 
                    flashSuccess('LogmessageRegSuccess'); 
                ?>

                <form class="w-full space-y-4 text-left" action="./Process/Register.php" method="POST">
                    <div class="flex flex-col">
                        <label for="signupName" class="text-sm font-bold uppercase tracking-wider mb-1">Name</label>
                        <input id="signupName" name="signupName" type="text" class="border border-[#1F2933]/30 rounded-md w-full h-10 p-3 bg-[#D0DACA]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F2933]" />
                    </div>

                    <div class="flex flex-col">
                        <label for="signupEmail" class="text-sm font-bold uppercase tracking-wider mb-1">Email</label>
                        <input id="signupEmail" name="signupEmail" type="email" required class="border border-[#1F2933]/30 rounded-md w-full h-10 p-3 bg-[#D0DACA]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F2933]" />
                    </div>

                    <div class="flex flex-col">
                        <label for="signupPassword" class="text-sm font-bold uppercase tracking-wider mb-1">Password</label>
                        <input id="signupPassword" name="signupPassword" type="password" class="border border-[#1F2933]/30 rounded-md w-full h-10 p-3 bg-[#D0DACA]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F2933]" />
                    </div>

                    <div class="flex flex-col">
                        <label for="confirmPassword" class="text-sm font-bold uppercase tracking-wider mb-1">Confirm Password</label>
                        <input id="confirmPassword" name="confirmPassword" type="password" class="border border-[#1F2933]/30 rounded-md w-full h-10 p-3 bg-[#D0DACA]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F2933]" />
                    </div>

                    <div class="flex flex-row gap-2 pt-2">
                        <input type="submit" name="signUp" value="Create" class="w-full h-12 bg-[#1F2933] text-[#D0DACA] rounded-md font-bold cursor-pointer hover:opacity-90 transition-all shadow-md active:scale-[0.98]" />
                        
                        <button type="button" onclick="document.getElementById('authPanel').classList.add('hidden')" class="w-full h-12 border-2 border-[#1F2933] text-[#1F2933] rounded-md font-bold hover:bg-[#1F2933] hover:text-[#D0DACA] transition-all duration-200">
                            Cancel
                        </button>
                    </div>
                </form>

                <p class="mt-4 text-sm opacity-80">
                    Already have an account? 
                    <button id="showSignIn" class="text-[#1F2933] font-bold hover:opacity-70 cursor-pointer">Sign-In!</button>
                </p>
            </div>
        </div>
    </div>

    <section id="Home"  class="px-6 md:px-20 py-16 md:py-24 flex flex-col md:flex-row items-center bg-[#bdc3b2]">
        <div class="md:w-3/5 space-y-8">
            <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                Storage and Security <br> 
                <span class="opacity-70 text-[#1F2933]">for generations</span>
            </h1>
            <p class="text-[#1F2933]/70 text-lg max-w-lg font-medium">
                Empower your potential with us and prepare for a future filled with opportunity. <br>
            </p>
            <button class="bg-[#1F2933] text-[#D0DACA] px-8 py-3 rounded-md font-semibold cursor-pointer">
                Register
            </button>
        </div>
        <div class="md:w-2/5 mt-12 md:mt-0">
            <img src="./Assets/Images/cyber.gif" alt="Hero" class="w-full h-auto rounded-2xl shadow-sm">
        </div>
    </section>

    <section id="Features" class="py-16 px-6 md:px-20 text-center">
        <h2 class="text-3xl font-bold max-w-xl mx-auto">Manage your entire community in a single system</h2>
        <p class="text-[#1F2933]/70 mt-3">Who is FOIMS suitable for?</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-12">
            <div class="p-8 bg-[#C7CFBE] shadow-sm rounded-xl border border-[#1F2933]/20 hover:shadow-md transition">
                <div class="w-16 h-16 bg-[#1F2933] rounded-tl-3xl rounded-br-3xl mx-auto mb-4 flex items-center justify-center text-3xl">👥</div>
                <h3 class="text-xl font-bold mb-3 uppercase tracking-wider">Individuals</h3>
                <p class="text-sm opacity-80">Our management software provides free access to all features for individuals.</p>
            </div>
            <div class="p-8 bg-[#C7CFBE] shadow-sm rounded-xl border border-[#1F2933]/20 hover:shadow-md transition">
                <div class="w-16 h-16 bg-[#1F2933] rounded-tl-3xl rounded-br-3xl mx-auto mb-4 flex items-center justify-center text-3xl">🏛️</div>
                <h3 class="text-xl font-bold mb-3 uppercase tracking-wider">Associations</h3>
                <p class="text-sm opacity-80">Our management software provides free access to all features for large and small associations.</p>
            </div>
            <div class="p-8 bg-[#C7CFBE] shadow-sm rounded-xl border border-[#1F2933]/20 hover:shadow-md transition">
                <div class="w-16 h-16 bg-[#1F2933] rounded-tl-3xl rounded-br-3xl mx-auto mb-4 flex items-center justify-center text-3xl">🤝</div>
                <h3 class="text-xl font-bold mb-3 uppercase tracking-wider">Groups</h3>
                <p class="text-sm opacity-80">Our management software provides free access to all features for different groups.</p>
            </div>
        </div>
    </section>

    <section id="Community" class="bg-[#bdc3b2] py-16 px-6 md:px-20 flex flex-col md:flex-row justify-between items-center gap-12 border-y border-[#1F2933]/10">
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-[#1F2933]">Helping every local <br>business manage their future</h2>
            <p class="mt-2 text-[#1F2933]/60">Reaching goals with dedication and inventory-tight precision.</p>
        </div>
        <div class="md:w-1/2 grid grid-cols-2 gap-x-10 gap-y-12">
            <div class="flex items-center space-x-4">
                <span class="text-3xl">👤</span>
                <div><h4 class="text-2xl font-bold">2,245,341</h4><p class="text-sm opacity-70">Members</p></div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-3xl">🏘️</span>
                <div><h4 class="text-2xl font-bold">46,328</h4><p class="text-sm opacity-70">Clubs</p></div>
            </div>
        </div>
    </section>

    <section id="Demo" class="py-20 text-center">
        <h2 class="text-4xl md:text-5xl font-bold max-w-2xl mx-auto leading-tight">
            Start your journey with FOIMS today.
        </h2>
        <button class="mt-8 bg-[#1F2933] text-[#D0DACA] px-8 py-4 rounded-md font-bold uppercase tracking-widest hover:opacity-90 cursor-pointer">
            Get a Demo
        </button>
    </section>

    <footer class="bg-[#1F2933] text-[#D0DACA] px-6 md:px-20 py-16">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-6">
                <div class="flex items-center space-x-1">
                    <img class="h-10 w-10" src="./Assets/Icons/MaterialsCo_Logo.svg" alt="FOIMS logo">
                    <span class="text-2xl font-bold">FOIMS</span>
                </div>
                <p class="text-sm opacity-70">Copyright © 2026 Nexcent ltd. <br>Inventory Management System</p>
            </div>
            <div>
                <h4 class="font-bold mb-6 underline underline-offset-8">Company</h4>
                <ul class="space-y-3 opacity-80">
                    <li><a href="#" class="hover:underline">About us</a></li>
                    <li><a href="#" class="hover:underline">Blog</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 underline underline-offset-8">Support</h4>
                <ul class="space-y-3 opacity-80">
                    <li><a href="#" class="hover:underline">Help center</a></li>
                    <li><a href="#" class="hover:underline">Terms of service</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6">Stay up to date</h4>
                <div class="relative">
                    <input type="email" placeholder="Email address" class="w-full bg-[#D0DACA] text-[#1F2933] placeholder-[#1F2933]/50 px-4 py-3 rounded-md outline-none">
                </div>
            </div>
        </div>
    </footer>

    <?php 
        //Scripts
        include __DIR__ ."/Scripts/indexScript.php";
    ?>

</body>
