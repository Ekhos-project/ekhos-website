class Question {
    constructor(selector) {
        this.selector = selector;
        this.expand = selector.querySelector(".questions_item_expand");
        this.search = document.querySelector(".section-faq#title .faq_title_search");
        this.open = false;
        this.events();
    }

    events() {
        this.expand.addEventListener("click", () => {
            if (this.open) {
                this.selector.classList.remove("open");
                this.expand.classList.remove("open");
            } else {
                this.selector.classList.add("open");
                this.expand.classList.add("open");
            }
            this.open = !this.open;
        });

        this.search.querySelector("button").addEventListener("click", () => {
            const value = this.search.querySelector("input").value;

            if(!this.selector.querySelector(".questions_item_title") || !value){
                return;
            }

            const questionTitle = this.selector.querySelector(".questions_item_title").innerText;
            const questionResponse = this.selector.querySelector(".questions_item_response").innerText;

            if(questionTitle.includes(value) || questionResponse.includes(value)){
                this.open = true;
                this.selector.classList.add("open");
                this.expand.classList.add("open");
            }
        });
    }
}

export default function () {
    const questions = document.querySelectorAll(
        ".section-faq#questions .questions_item, .footer_questions .footer_questions_item"
    );
    questions.forEach((selector) => {
        const question = new Question(selector);
    });
}
