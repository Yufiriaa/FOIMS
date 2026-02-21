<script>

  //Functionality for Panels of Signup and Signin 
    const showSignUp = document.getElementById('showSignUp');
    const showSignIn = document.getElementById('showSignIn');
    const SignInForm = document.getElementById('SignInForm');
    const SignUpForm = document.getElementById('SignUpForm');
    const authPanel = document.getElementById('authPanel');
    const openAuthPanel = document.getElementById('openAuthPanel');

    showSignUp.addEventListener('click', () => {
        SignInForm.classList.add('hidden');
        SignUpForm.classList.remove('hidden');
    });

    showSignIn.addEventListener('click', () => {
        SignUpForm.classList.add('hidden');
        SignInForm.classList.remove('hidden');
    });

    openAuthPanel.addEventListener('click', () => {
        authPanel.classList.remove('hidden');
        SignUpForm.classList.remove('hidden');
        SignInForm.classList.add('hidden');
    });


</script>
