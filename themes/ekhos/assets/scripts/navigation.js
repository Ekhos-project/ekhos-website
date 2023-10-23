
class Navigation {
    constructor(selector) {
        this.selector = selector;
        this.links = this.generateLinks();
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
