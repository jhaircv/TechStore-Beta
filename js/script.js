document.addEventListener('DOMContentLoaded', () => {
    // INICIALIZACIÓN GENERAL
    cargarProductos();
    inicializarEventosGenerales();
    initChatbotAfterLoad();

});

// ------------------- GESTIÓN DE PRODUCTOS -------------------
let productosBD = [];

function cargarProductos() {
    fetch('api_productos.php')
        .then(res => res.ok ? res.json() : Promise.reject(res))
        .then(productos => {
            productosBD = productos;
            // Aquí podrías llamar a una función que renderice productos si es necesario en la carga inicial
        })
        .catch(error => console.error('Error al cargar los productos:', error));
}

// ------------------- EVENTOS GENERALES Y OTROS -------------------
function inicializarEventosGenerales() {
    // Botón Scroll Top
    const btnScrollTop = document.getElementById('btnScrollTop');
    if (btnScrollTop) {
        window.addEventListener('scroll', () => {
            btnScrollTop.style.display = (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) ? "block" : "none";
        });
        btnScrollTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Búsqueda de productos
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            const filtro = searchInput.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                const nombre = card.dataset.nombre.toLowerCase();
                const categoria = card.dataset.categoria.toLowerCase();
                card.style.display = (nombre.includes(filtro) || categoria.includes(filtro)) ? 'flex' : 'none';
            });
        });
    }

    // Cierre de modales
    window.addEventListener('click', function(event) {
        const modalProducto = document.getElementById('modalProducto');
        const categoriaModal = document.getElementById('categoria-modal');
        const carritoModal = document.getElementById('carritoModal');

        if (event.target == modalProducto) cerrarModalProducto();
        if (event.target == categoriaModal) cerrarModalCategoria();
        if (carritoModal.style.display === 'flex' && !carritoModal.contains(event.target) && !event.target.closest('.header-cart-icon')) {
            cerrarCarrito();
        }
    });

    // Navegación suave para anclas de categorías
    document.querySelectorAll('.dropdown-content a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerOffset = document.querySelector('.header-principal').offsetHeight;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
            }
        });
    });

    // Banner Carousel
    const carousel = document.querySelector('.banner-carousel');
    if (carousel) {
        const slides = document.querySelectorAll('.banner-slide');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        let currentIndex = 0;

        function goToSlide(index) {
            if (slides.length === 0) return;
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            carousel.style.transform = `translateX(-${index * 100}%)`;
            currentIndex = index;
        }

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
            nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
            setInterval(() => goToSlide(currentIndex + 1), 5000);
        }
    }
}

// ==================== NUEVO CHATBOT (VERSIÓN SEGURA) ====================
// ==================== TU CLASE TechStoreChatbot AQUÍ ====================
class TechStoreChatbot {
    constructor() {
        this.containerId = 'techstore-chatbot-container';
        this.fabId = 'techstore-chatbot-fab';
        this.init();
    }

    init() {
        this.injectHTML();
        this.fab = document.getElementById(this.fabId);
        this.container = document.getElementById(this.containerId);
        this.closeBtn = document.querySelector(`#${this.containerId} .chatbot-close`);
        this.setupEvents();
        console.log('🤖 Chatbot mejorado inicializado');
    }

    injectHTML() {
    const chatbotHTML = `
    <div id="${this.fabId}" class="chatbot-fab">
        <i class="fas fa-comments"></i>
    </div>
    <div id="${this.containerId}" class="chatbot-main">
        <div class="chatbot-header">
            <h3>Asistente TechStore</h3>
            <button class="chatbot-close">&times;</button>
        </div>
        
        <div class="chatbot-content-wrapper">
            <div class="chatbot-body">
                <div class="chatbot-messages" id="chatbot-messages"></div>
            </div>
            
            <div class="chatbot-options" id="chatbot-options"></div>
        </div>
    </div>
    `;
    document.body.insertAdjacentHTML('beforeend', chatbotHTML);
}

    setupEvents() {
        this.fab.addEventListener('click', (event) => { // Pasar 'event' para detener la propagación
            event.stopPropagation(); // Evita que el clic en el FAB cierre el chatbot
            const wasHidden = this.container.style.display === 'none' || this.container.style.display === '';
            this.toggleChatbot(); 

            if (wasHidden) {
                this.showWelcomeMessage();
            }
        });

        this.closeBtn.addEventListener('click', (event) => { // Pasar 'event'
            event.stopPropagation(); // Evita que el clic en el botón de cerrar cierre el chatbot
            this.toggleChatbot(false);
        });

        // ⭐ NUEVO: Cierre al hacer clic fuera del chatbot ⭐
        document.addEventListener('click', (event) => {
            // Si el chatbot está visible Y el clic no fue dentro del contenedor del chatbot
            // Y el clic no fue en el botón FAB (para evitar doble cierre/apertura)
            if (this.container.style.display === 'flex' && 
                !this.container.contains(event.target) && 
                !this.fab.contains(event.target)) {
                this.toggleChatbot(false);
            }
        });

        // Prevenir que los clics dentro del chatbot se propaguen y lo cierren
        this.container.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    }

    toggleChatbot(show = null) {
        this.container.style.display = show !== null ? 
            (show ? 'flex' : 'none') : 
            (this.container.style.display === 'flex' ? 'none' : 'flex');
    }

    showWelcomeMessage() {
        const messagesContainer = document.getElementById('chatbot-messages');
        const optionsContainer = document.getElementById('chatbot-options');
        
        messagesContainer.innerHTML = '';
        optionsContainer.innerHTML = '';
        
        this.addMessage('¡Hola! Soy tu asistente de TechStore. ¿En qué puedo ayudarte hoy?', 'bot');
        
        // Botones predefinidos mejorados
        const options = [
            { text: "📋 Ver categorías", action: "showCategories" },
            { text: "🔥 Ofertas flash", action: "showRandomOffers" },
            { text: "⭐ Productos destacados", action: "showFeaturedProducts" },
            { text: "🛒 Cómo comprar", action: "showHowToBuy" },
            { text: "🚚 Envíos y devoluciones", action: "showShippingInfo" },
            { text: "🏆 Sobre nosotros", action: "showAboutUs" }
        ];
        
        options.forEach(option => {
            const button = document.createElement('button');
            button.className = 'chatbot-option-btn';
            button.innerHTML = option.text;
            button.addEventListener('click', () => this.handleOption(option.action));
            optionsContainer.appendChild(button);
        });
    }

    addMessage(text, sender = 'bot') {
        const messagesContainer = document.getElementById('chatbot-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${sender}`;
        messageDiv.innerHTML = `<p>${text}</p>`;
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    handleOption(action) {
        const options = [
            { text: "📋 Ver categorías", action: "showCategories" },
            { text: "🔥 Ofertas flash", action: "showRandomOffers" },
            { text: "⭐ Productos destacados", action: "showFeaturedProducts" },
            { text: "🛒 Cómo comprar", action: "showHowToBuy" },
            { text: "🚚 Envíos y devoluciones", action: "showShippingInfo" },
            { text: "🏆 Sobre nosotros", action: "showAboutUs" }
        ];
        const selectedOptionText = options.find(opt => opt.action === action)?.text || action;
        this.addMessage(`> ${selectedOptionText}`, 'user');
        
        switch(action) {
            case 'showCategories':
                this.showCategories();
                break;
            case 'showRandomOffers':
                this.showRandomOffers();
                break;
            case 'showFeaturedProducts':
                this.showFeaturedProducts();
                break;
            case 'showHowToBuy':
                this.showHowToBuy();
                break;
            case 'showShippingInfo':
                this.showShippingInfo();
                break;
            case 'showAboutUs':
                this.showAboutUs();
                break;
            default:
                this.addMessage("Lo siento, no entendí esa opción.", 'bot');
        }
    }

    showCategories() {
        const categories = [...new Set(productosBD.map(p => p.categoria))].filter(Boolean);
        
        this.addMessage("📋 Nuestras categorías principales:", 'bot');
        
        const optionsContainer = document.getElementById('chatbot-options');
        optionsContainer.innerHTML = '';
        
        categories.forEach(category => {
            const button = document.createElement('button');
            button.className = 'chatbot-option-btn';
            button.textContent = category;
            button.addEventListener('click', () => {
                this.navigateToSection(category.toLowerCase().replace(/\s+/g, '-'));
            });
            optionsContainer.appendChild(button);
        });
        
        this.addBackButton();
    }

    showRandomOffers() {
        const randomProducts = [...productosBD]
            .sort(() => 0.5 - Math.random())
            .slice(0, 3);
        
        this.addMessage("🔥 Estas son nuestras ofertas especiales de hoy:", 'bot');
        
        randomProducts.forEach(product => {
            const discountPrice = (product.precio * 0.8).toFixed(2);
            const productMessage = document.createElement('div');
            productMessage.className = 'chatbot-message bot product-clickable';
            productMessage.innerHTML = `<p>✔ ${product.nombre} - <s>S/${product.precio}</s> <strong>S/${discountPrice}</strong> (20% OFF)</p>`;
            productMessage.addEventListener('click', () => this.highlightAndScrollToProduct(product.id));
            document.getElementById('chatbot-messages').appendChild(productMessage);
        });
        
        const optionsContainer = document.getElementById('chatbot-options');
        optionsContainer.innerHTML = '';
        this.addBackButton();
    }

    showFeaturedProducts() {
        const featuredProducts = [...productosBD]
            .sort((a, b) => b.precio - a.precio)
            .slice(0, 3);
        
        this.addMessage("⭐ Nuestros productos premium recomendados:", 'bot');
        
        featuredProducts.forEach(product => {
            const productMessage = document.createElement('div');
            productMessage.className = 'chatbot-message bot product-clickable';
            productMessage.innerHTML = `<p>★ ${product.nombre} - S/${product.precio} (${product.marca})</p>`;
            productMessage.addEventListener('click', () => this.highlightAndScrollToProduct(product.id));
            document.getElementById('chatbot-messages').appendChild(productMessage);
        });
        
        const optionsContainer = document.getElementById('chatbot-options');
        optionsContainer.innerHTML = '';
        this.addBackButton();
    }

    showHowToBuy() {
        this.addMessage("🛒 Cómo comprar en TechStore:", 'bot');
        this.addMessage("1. Navega por nuestras categorías", 'bot');
        this.addMessage("2. Haz clic en 'Añadir al carrito'", 'bot');
        this.addMessage("3. Ve a tu carrito y completa tus datos", 'bot');
        this.addMessage("4. ¡Recibirás tu pedido en 24-48 horas!", 'bot');
        
        const optionsContainer = document.getElementById('chatbot-options');
        optionsContainer.innerHTML = '';
        this.addBackButton();
    }

    showShippingInfo() {
        this.addMessage("🚚 Información de envíos:", 'bot');
        this.addMessage("• Envío gratis para compras mayores a S/200", 'bot');
        this.addMessage("• Lima Metropolitana: 1-2 días hábiles", 'bot');
        this.addMessage("• Provincias: 3-5 días hábiles", 'bot');
        this.addMessage("• Devoluciones gratuitas en 15 días", 'bot');
        
        const optionsContainer = document.getElementById('chatbot-options');
        optionsContainer.innerHTML = '';
        this.addBackButton();
    }

    showAboutUs() {
        this.addMessage("🏆 TechStore - La mejor tecnología al mejor precio", 'bot');
        this.addMessage("• Más de 10 años en el mercado", 'bot');
        this.addMessage("• +50,000 clientes satisfechos", 'bot');
        this.addMessage("• Atención personalizada 24/7", 'bot');
        
        const optionsContainer = document.getElementById('chatbot-options');
        optionsContainer.innerHTML = '';
        this.addBackButton();
    }

    navigateToSection(id) {
        const targetElement = document.getElementById(id);
        
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            this.addMessage(`🔍 Te llevaré a la sección de ${id.replace(/-/g, ' ')}`, 'bot');
            this.toggleChatbot(false);
            
            targetElement.classList.add('highlight-section');
            setTimeout(() => {
                targetElement.classList.remove('highlight-section');
            }, 1500);
            
        } else {
            this.addMessage(`⚠ No encontré la sección: ${id}`, 'bot');
        }
    }

    highlightAndScrollToProduct(productId) {
        this.toggleChatbot(false);

        // ⭐ Asegúrate que tus tarjetas de producto en el HTML tengan el ID correcto ⭐
        // Ej: <div class="product-card" id="product-laptop-hp-pavilion">...</div>
        // O si tu ID de producto es solo un número, ej: <div class="product-card" id="product-123">...</div>
        const productCard = document.getElementById(`product-${productId}`); 

        if (productCard) {
            productCard.scrollIntoView({ behavior: 'smooth', block: 'center' });

            productCard.classList.add('product-selected-animation');

            setTimeout(() => {
                productCard.classList.remove('product-selected-animation');
            }, 2000); // La animación durará 2 segundos
        } else {
            // Si el producto no se encuentra, puedes reabrir el chatbot para informar
            this.addMessage(`Lo siento, no pude encontrar el producto con ID "${productId}" en la página.`, 'bot');
            console.warn(`Producto con ID ${productId} no encontrado en el DOM.`);
            this.toggleChatbot(true); // Reabrir el chatbot para que el usuario vea el mensaje
        }
    }

    addBackButton() {
        const optionsContainer = document.getElementById('chatbot-options');
        const backButton = document.createElement('button');
        backButton.className = 'chatbot-option-btn back';
        backButton.textContent = '« Volver al inicio';
        backButton.addEventListener('click', () => this.showWelcomeMessage());
        optionsContainer.appendChild(backButton);
    }
}

// Inicialización mejorada
function initChatbotAfterLoad() {
    if (typeof productosBD !== 'undefined' && productosBD && productosBD.length > 0) {
        new TechStoreChatbot();
    } else {
        setTimeout(initChatbotAfterLoad, 500);
    }
}