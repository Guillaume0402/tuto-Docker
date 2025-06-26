// JavaScript principal de l'application
document.addEventListener("DOMContentLoaded", function () {
    console.log("Application tuto-Docker chargée");

    // Initialisation des fonctionnalités
    initNavigation();
    initForms();
    initAlerts();
    initAnimations();
});

// Gestion de la navigation
function initNavigation() {
    // Mise en évidence du lien actif
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach((link) => {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
        }
    });

    // Menu mobile (si nécessaire)
    const navToggle = document.querySelector(".navbar-toggler");
    if (navToggle) {
        navToggle.addEventListener("click", function () {
            const navCollapse = document.querySelector(".navbar-collapse");
            navCollapse.classList.toggle("show");
        });
    }
}

// Gestion des formulaires
function initForms() {
    // Validation côté client
    const forms = document.querySelectorAll("form[data-validate]");

    forms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!validateForm(form)) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add("was-validated");
        });
    });

    // Affichage dynamique des erreurs
    const inputs = document.querySelectorAll(".form-control");
    inputs.forEach((input) => {
        input.addEventListener("blur", function () {
            validateInput(input);
        });

        input.addEventListener("input", function () {
            clearValidation(input);
        });
    });
}

// Validation d'un formulaire
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll("[required]");

    requiredFields.forEach((field) => {
        if (!field.value.trim()) {
            showFieldError(field, "Ce champ est requis");
            isValid = false;
        } else if (field.type === "email" && !isValidEmail(field.value)) {
            showFieldError(field, "Adresse email invalide");
            isValid = false;
        } else if (field.type === "password" && field.value.length < 6) {
            showFieldError(
                field,
                "Le mot de passe doit contenir au moins 6 caractères"
            );
            isValid = false;
        }
    });

    return isValid;
}

// Validation d'un champ individuel
function validateInput(input) {
    if (input.hasAttribute("required") && !input.value.trim()) {
        showFieldError(input, "Ce champ est requis");
        return false;
    }

    if (input.type === "email" && input.value && !isValidEmail(input.value)) {
        showFieldError(input, "Adresse email invalide");
        return false;
    }

    if (input.type === "password" && input.value && input.value.length < 6) {
        showFieldError(
            input,
            "Le mot de passe doit contenir au moins 6 caractères"
        );
        return false;
    }

    clearValidation(input);
    return true;
}

// Affichage d'une erreur de champ
function showFieldError(field, message) {
    field.classList.add("is-invalid");

    let errorDiv = field.parentNode.querySelector(".invalid-feedback");
    if (!errorDiv) {
        errorDiv = document.createElement("div");
        errorDiv.className = "invalid-feedback";
        field.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
}

// Effacement de la validation d'un champ
function clearValidation(field) {
    field.classList.remove("is-invalid");
    const errorDiv = field.parentNode.querySelector(".invalid-feedback");
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Validation d'email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Gestion des alertes
function initAlerts() {
    // Auto-fermeture des alertes après 5 secondes
    const alerts = document.querySelectorAll(".alert[data-auto-dismiss]");
    alerts.forEach((alert) => {
        setTimeout(() => {
            fadeOut(alert);
        }, 5000);
    });

    // Boutons de fermeture des alertes
    const closeButtons = document.querySelectorAll(".alert .btn-close");
    closeButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const alert = button.closest(".alert");
            fadeOut(alert);
        });
    });
}

// Animation de fondu sortant
function fadeOut(element) {
    element.style.opacity = "0";
    element.style.transform = "translateY(-10px)";
    setTimeout(() => {
        element.remove();
    }, 300);
}

// Initialisation des animations
function initAnimations() {
    // Animation d'apparition au scroll
    const animatedElements = document.querySelectorAll("[data-animate]");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate-in");
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.1,
        }
    );

    animatedElements.forEach((element) => {
        observer.observe(element);
    });
}

// Fonction utilitaire pour les requêtes AJAX
function makeRequest(url, options = {}) {
    const defaultOptions = {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
    };

    const finalOptions = { ...defaultOptions, ...options };

    return fetch(url, finalOptions)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .catch((error) => {
            console.error("Erreur de requête:", error);
            throw error;
        });
}

// Fonction pour afficher des notifications
function showNotification(message, type = "info", duration = 3000) {
    const notification = document.createElement("div");
    notification.className = `alert alert-${type} notification`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    `;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Animation d'entrée
    setTimeout(() => {
        notification.style.opacity = "1";
        notification.style.transform = "translateX(0)";
    }, 100);

    // Auto-suppression
    setTimeout(() => {
        notification.style.opacity = "0";
        notification.style.transform = "translateX(100%)";
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, duration);
}

// Export des fonctions pour utilisation globale
window.showNotification = showNotification;
window.makeRequest = makeRequest;
