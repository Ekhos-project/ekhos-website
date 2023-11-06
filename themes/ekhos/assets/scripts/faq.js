class Question {
    constructor(selector) {
        this.selector = selector;
        this.expand = selector.querySelector(".questions_item_expand");
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
