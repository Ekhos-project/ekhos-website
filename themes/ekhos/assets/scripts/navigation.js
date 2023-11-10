
class Navigation {
    constructor(selector) {
        this.selector = selector;
        this.links = this.generateLinks();
        this.burger = this.generateBurger();
    }

    generateLinks() {
        const links = this.selector.querySelectorAll(".menu-item");
        const linksObject = [];
        links.forEach((selector) => {
            const link = new NavigationLink(selector, this);
            linksObject.push(link);
        });
        return linksObject;
    }

    generateBurger() {
        const burger = document.querySelector("header .navigation_burger");
        const burgerObject = new Burger(burger, this);
        return burgerObject;
    }
}


class Burger {
    constructor(selector, navigation) {
        this.selector = selector;
        this.navigation = navigation;
        this.menu = this.navigation.selector.querySelector(".navigation_menu");
        this.active = false;
        this.events();
    }

    events() {
        this.selector.addEventListener("click", ()=>{
            if(this.active) {
                this.menu.classList.remove("open");
                this.selector.classList.remove("open");
            } else{
                this.menu.classList.add("open");
                this.selector.classList.add("open");
            }
            this.active = !this.active;
        });
    }
}


class NavigationLink {
    constructor(selector, navigation) {
        this.selector = selector;
        this.navigation = navigation;
        this.redirect = this.generateRedirect();
        this.active = false;
        this.children = this.generateChildren();
        this.events();
    }

    generateRedirect() {
        return Array.from(this.selector.children).filter(
            child => (child.tagName === "A")
        )[0];
    }

    generateChildren() {
        if (this.selector.classList.contains("menu-item-has-children")) {
            return Array.from(this.selector.children).filter(
                child => child.classList.contains("sub-menu")
            )[0];
        }
        return false;
    }

    events() {
        this.redirect.addEventListener("click", (e)=>{
            if (this.children) {
                e.preventDefault();
            }
        });

        this.selector.addEventListener("mouseover", ()=>{
            if(!this.children) {
                return;
            }
            this.children.classList.add("active");
        });

        this.selector.addEventListener("mouseleave", ()=>{
            if(!this.children) {
                return;
            }
            this.children.classList.remove("active");
        });
    }
}

export default function () {
    const navigationSelector = document.querySelector("header > nav")
    const navigation = new Navigation(navigationSelector);
}
