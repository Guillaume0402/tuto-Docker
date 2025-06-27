const express = require("express");
const helmet = require("helmet");
const cors = require("cors");
const compression = require("compression");

const app = express();
const PORT = process.env.PORT || 3000;
const NODE_ENV = process.env.NODE_ENV || "development";

// Middleware de sécurité
app.use(helmet());
app.use(cors());
app.use(compression());
app.use(express.json({ limit: "10mb" }));

// Logs de démarrage
console.log(`🚀 Starting Node.js application in ${NODE_ENV} mode`);
console.log(`📦 Node version: ${process.version}`);
console.log(`🐳 Running in Docker container`);

// Route racine
app.get("/", (req, res) => {
    res.json({
        message: "🐳 Application Node.js optimisée pour Docker !",
        version: "1.0.0",
        environment: NODE_ENV,
        timestamp: new Date().toISOString(),
        uptime: Math.floor(process.uptime()),
        memory: {
            used:
                Math.round(process.memoryUsage().heapUsed / 1024 / 1024) +
                " MB",
            total:
                Math.round(process.memoryUsage().heapTotal / 1024 / 1024) +
                " MB",
        },
    });
});

// Route de santé pour le health check
app.get("/health", (req, res) => {
    const healthCheck = {
        status: "OK",
        timestamp: new Date().toISOString(),
        uptime: process.uptime(),
        environment: NODE_ENV,
        memory: process.memoryUsage(),
        pid: process.pid,
    };

    try {
        res.status(200).json(healthCheck);
    } catch (error) {
        healthCheck.status = "ERROR";
        healthCheck.error = error.message;
        res.status(503).json(healthCheck);
    }
});

// Route d'information système
app.get("/info", (req, res) => {
    res.json({
        node: {
            version: process.version,
            platform: process.platform,
            arch: process.arch,
            pid: process.pid,
            uptime: process.uptime(),
        },
        memory: process.memoryUsage(),
        environment: process.env.NODE_ENV,
        docker: {
            optimized: true,
            multiStage: true,
            alpine: true,
            nonRoot: true,
        },
    });
});

// Route de test de charge
app.get("/stress/:seconds", (req, res) => {
    const seconds = parseInt(req.params.seconds) || 1;
    const start = Date.now();

    // Simulation d'une tâche CPU intensive
    while (Date.now() - start < seconds * 1000) {
        Math.sqrt(Math.random() * 1000000);
    }

    res.json({
        message: `Stress test completed`,
        duration: `${seconds} seconds`,
        timestamp: new Date().toISOString(),
    });
});

// Middleware de gestion d'erreurs
app.use((err, req, res, next) => {
    console.error("❌ Error:", err.message);
    res.status(500).json({
        error: "Internal Server Error",
        message:
            NODE_ENV === "development" ? err.message : "Something went wrong",
    });
});

// Middleware pour les routes non trouvées
app.use("*", (req, res) => {
    res.status(404).json({
        error: "Not Found",
        message: `Route ${req.originalUrl} not found`,
        availableRoutes: ["/", "/health", "/info", "/stress/:seconds"],
    });
});

// Gestion propre de l'arrêt
process.on("SIGTERM", () => {
    console.log("📝 SIGTERM received, shutting down gracefully");
    server.close(() => {
        console.log("✅ Process terminated");
        process.exit(0);
    });
});

process.on("SIGINT", () => {
    console.log("📝 SIGINT received, shutting down gracefully");
    server.close(() => {
        console.log("✅ Process terminated");
        process.exit(0);
    });
});

// Démarrage du serveur
const server = app.listen(PORT, "0.0.0.0", () => {
    console.log(`🌟 Server running on port ${PORT}`);
    console.log(`🔗 Health check: http://localhost:${PORT}/health`);
    console.log(`📊 System info: http://localhost:${PORT}/info`);
});

module.exports = app;
