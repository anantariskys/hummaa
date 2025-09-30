@extends('layouts.tryout-layout')

@section('content')
    <div
        x-data='ujianState(
    @json($questions),
     {{ $attempt->attempt_id }},
       {{ $tryout->duration_minutes }},
        @json($userAnswers ?? []))'>
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start">
            <div class="w-full lg:w-1/3">
                <x-tryout.grid-question-number :title="$tryout->title" :imageUrl="asset('images/tpa-logo.png')" />
            </div>

            <div class="w-full lg:w-2/3">
                <x-tryout.question-card />
            </div>
        </div>
        <x-tryout.confirm-submit-modal />
    </div>

    <script>
        function ujianState(questionsData, attemptId, durationMinutes, initialAnswers = {}) {
            const urlParams = new URLSearchParams(window.location.search);
            const pageMode = urlParams.get('mode') || 'tryout';

            return {
                mode: pageMode,
                questions: questionsData,
                attemptId: attemptId,
                timeLeft: durationMinutes * 60,

                // STATE
                currentIndex: 0,
                answers: initialAnswers,
                isModalOpen: false,
                feedbackShown: {},

                // COMPUTED PROPERTIES (Getters)
                get currentQuestion() {
                    return this.questions.length > 0 ? this.questions[this.currentIndex] : null;
                },
                get totalQuestions() {
                    return this.questions.length;
                },

                // METHODS
                init() {
                    if (this.mode === 'tryout') {
                        window.addEventListener('beforeunload', (event) => {
                            event.preventDefault();
                            event.returnValue = '';
                        });
                        const timer = setInterval(() => {
                            if (this.timeLeft > 0) {
                                this.timeLeft--;
                            } else {
                                clearInterval(timer);
                            }
                        }, 1000);
                    }
                },
                selectAnswer(optionKey, optionId = null, answerText = null) {
                    this.answers[this.currentQuestion.id] = {
                        key: optionKey,
                        optionId: optionId,
                        text: answerText
                    };
                    console.log(`Soal ${this.currentQuestion.id} dijawab:`, this.answers[this.currentQuestion.id]);
                },

                changeQuestion(index) {
                    if (index >= 0 && index < this.totalQuestions) {
                        this.currentIndex = index;
                    }
                },
                nextQuestion() {
                    if (this.currentIndex < this.totalQuestions - 1) {
                        this.currentIndex++;
                    }
                },
                prevQuestion() {
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                    }
                },
                getQuestionStatus(questionNumber) {
                    const questionIndex = questionNumber - 1;
                    const questionId = this.questions[questionIndex]?.id;

                    if (this.currentIndex === questionIndex) return 'active';
                    if (this.answers.hasOwnProperty(questionId)) return 'answered';
                    return 'unanswered';
                },
                formatTime() {
                    const hours = Math.floor(this.timeLeft / 3600).toString().padStart(2, '0');
                    const minutes = Math.floor((this.timeLeft % 3600) / 60).toString().padStart(2, '0');
                    const seconds = (this.timeLeft % 60).toString().padStart(2, '0');
                    return `${hours}:${minutes}:${seconds}`;
                },

                toggleMode() {
                    this.mode = (this.mode === 'tryout') ? 'belajar' : 'tryout';
                    console.log('Mode diubah menjadi:', this.mode);
                },

                submitExam() {
                    this.isModalOpen = false;
                    console.log('Proses submit dimulai...');

                    fetch(`/tryout/submit/${this.attemptId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                answers: this.answers
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Sukses:', data);
                            window.location.href = data.result_url;
                        })
                        .catch(error => {
                            console.error('Terjadi Error:', error);
                            alert('Gagal mengirim jawaban. Silakan cek konsol untuk detail.');
                        });
                },
            }
        }
    </script>
@endsection
