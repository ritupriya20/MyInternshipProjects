document.addEventListener('DOMContentLoaded', function() {
    const questions = [
        {
            question: "What is the purpose of the 'localStorage' in JavaScript?",
            options: ["To store data on the server", "To store data in the browser for later use", "To encrypt sensitive information", "To validate form inputs"],
            answer: "To store data in the browser for later use",
            selectedOption: null
        },
        {
        question: "What is the purpose of the 'viewport' meta tag in HTML?",
        options: ["To set the page's background color", "To control the layout and scaling of a webpage on different devices", "To define the font size of the page", "To specify the page's character encoding"],
        answer: "To control the layout and scaling of a webpage on different devices",
        selectedOption: null
        },
        {
            question: "What is JavaScript primarily used for?",
            options: ["Styling web pages", "Adding interactivity to websites", "Creating databases", "Managing server-side operations"],
            answer: "Adding interactivity to websites",
            selectedOption: null
        },
        {
            question: "Which of the following is not a programming language?",
            options: ["Python", "Java", "HTML", "C++"],
            answer: "HTML",
            selectedOption: null
        },
        {
            question: "What does CSS stand for?",
            options: ["Cascading Style Sheets", "Counter Strike: Source", "Central Style Sheet", "Cascading Style Syntax"],
            answer: "Cascading Style Sheets",
            selectedOption: null
        },
        {
            question: "Which language is often used for server-side scripting?",
            options: ["JavaScript", "Python", "PHP", "HTML"],
            answer: "PHP",
            selectedOption: null
        },
        {
            question: "What is the purpose of the 'alt' attribute in an HTML image tag?",
            options: ["To define alternative text for an image", "To link to another web page", "To specify the image source", "To set the image width"],
            answer: "To define alternative text for an image",
            selectedOption: null
        },
        {
            question: "What does AJAX stand for?",
            options: ["Asynchronous JavaScript and XML", "Advanced JavaScript and XML", "Asynchronous JavaScript and XHTML", "Advanced JavaScript and XHTML"],
            answer: "Asynchronous JavaScript and XML",
            selectedOption: null
        },
        {
            question: "What is the purpose of a 'DOCTYPE' declaration in HTML?",
            options: ["To specify the version of HTML being used", "To create a new HTML document", "To link to an external stylesheet", "To define a function in JavaScript"],
            answer: "To specify the version of HTML being used",
            selectedOption: null
        },
        {
            question: "Which of the following is not a valid HTTP status code?",
            options: ["200 OK", "404 Not Found", "503 Service Unavailable", "300 Redirect"],
            answer: "300 Redirect",
            selectedOption: null
        }
        
    ];
    
    const urlParams = new URLSearchParams(window.location.search);
    const name = urlParams.get('name');
    if (name) {
        document.querySelector('input[name="name"]').value = name;
    }
    const urlParams1 = new URLSearchParams(window.location.search);
    const quizType = urlParams1.get('quizType');
    if (quizType) {
        document.querySelector('input[name="quizType"]').value = quizType;
    }
   

    let currentQuestion = 0;
    let score = 0;
    

    function displayQuestion() {
        const questionElement = document.getElementById('question');
        const optionsElement = document.getElementById('options');
        const questionNumberElement = document.getElementById('question-number'); 

        questionNumberElement.innerHTML = `Question <span style="color:black;">${currentQuestion + 1}</span> of 10`; 


        questionElement.innerHTML = questions[currentQuestion].question;

        optionsElement.innerHTML = '';
        questions[currentQuestion].options.forEach((option, index) => {
            optionsElement.innerHTML += `<br><input type="radio" name="answer" value="${option}" id="option${index}">
            <label class="option" for="option${index}">${option}</label><br>`;
        });
    }

    function nextQuestion() {
        
        console.log('Next question called');
        const selectedOption = document.querySelector('input[name="answer"]:checked');

        if (selectedOption) {
            questions[currentQuestion].selectedOption = selectedOption.value;

            if (selectedOption.value === questions[currentQuestion].answer) {
                score++;
            }

            currentQuestion++;
            if (currentQuestion < questions.length) {
                displayQuestion();
            } else {
                document.getElementById('next-btn').style.display = 'none'; 
                document.getElementById('submit-btn').style.display = 'block';
            }
        } else {
            alert('Please select an option before proceeding.');
        }
    }

    function showResult() {
        const resultElement = document.getElementById('result');
    resultElement.innerHTML = `Your score is <span style="color: #58b758;font-weight:800;">${score}</span> out of ${questions.length}`;

    document.getElementById('question-number').style.display = 'none'; 
        document.getElementById('quiz-container').style.display = 'none'; 
        document.getElementById('line').style.display = 'none';
        document.getElementById('result').style.display = 'block';
        document.getElementById('heading').style.display = 'block';
        analyzeQuiz();
        document.getElementById('analysis').style.display = 'block';
        document.getElementById('gotohome').style.display = 'block';
    }

    function submitQuiz() {
        console.log('Submit quiz called');
        submitButtonClicked = true;
        document.querySelector('input[name="score"]').value = score;
        if (typeof getCompletionTime !== 'undefined'&& getCompletionTime() > 0) {
            const TimeTaken=getCompletionTime();
            document.querySelector('input[name="completionTime"]').value = TimeTaken;   
        }
        const formData = new FormData(document.getElementById('quiz-form'));
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "save_leaderboard.php", true);
        xhttp.onload = function () {
            if (this.status === 200) {
                console.log('Result saved successfully');
            } else {
                console.error('Error saving result:', this.statusText);
            }
        };
        xhttp.send(formData);
    
        showResult();
    }
    
    

    function analyzeQuiz() {
        const analysisElement = document.getElementById('analysis');
        analysisElement.innerHTML = '';

        questions.forEach((question, index) => {
            const userAnswer = question.selectedOption;
            const isCorrect = userAnswer === question.answer;
            const analysisClass = isCorrect ? 'correct' : 'incorrect';

            const questionDiv = document.createElement('div');
            questionDiv.classList.add('question');

            questionDiv.innerHTML = `
                <strong>Question ${index + 1}:</strong> ${question.question}<br><br>
                ${question.options.map(option => `
                    <div class="${userAnswer === option ? analysisClass : ''}">${option}</div>
                `).join('')}<br>
                <div><strong>Your Answer:</strong> <span class="${analysisClass}">${userAnswer ? userAnswer : 'Not answered'}</span></div><br>
                <div><strong>Correct Answer:</strong> ${question.answer}</div><br><br>
            `;

            analysisElement.appendChild(questionDiv);
        });
    }

    document.getElementById('next-btn').addEventListener('click', nextQuestion);
    document.getElementById('submit-btn').addEventListener('click', submitQuiz);

    displayQuestion();
});
