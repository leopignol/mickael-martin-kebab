(() => {
    const canvas = document.getElementById("traffic-chart");
    if (!canvas) return;

    const context = canvas.getContext("2d");
    if (!context) {
        throw new Error("Unable to initialize the traffic chart canvas.");
    }

    let trafficData = [];

    function validateData(data) {
        if (!Array.isArray(data) || data.length < 2) {
            throw new TypeError("Traffic chart data must contain at least two points.");
        }

        data.forEach((point) => {
            if (
                typeof point.time !== "string"
                || !Number.isFinite(point.incoming) || point.incoming < 0
                || !Number.isFinite(point.outgoing) || point.outgoing < 0
            ) {
                throw new TypeError("Each traffic data point needs a time and non-negative incoming/outgoing values.");
            }
        });
    }

    function drawTrafficChart() {
        const width = canvas.clientWidth;
        const height = canvas.clientHeight;
        if (!width || !height) return;

        const pixelRatio = window.devicePixelRatio || 1;
        canvas.width = Math.round(width * pixelRatio);
        canvas.height = Math.round(height * pixelRatio);
        context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
        context.clearRect(0, 0, width, height);

        const styles = getComputedStyle(canvas);
        const textColor = styles.getPropertyValue("--text").trim() || "#F3E9DC";
        const incomingColor = styles.getPropertyValue("--amber").trim() || "#FF8F00";
        const outgoingColor = styles.getPropertyValue("--copper").trim() || "#C87532";
        const padding = { top: 12, right: 12, bottom: 30, left: 44 };
        const plotWidth = width - padding.left - padding.right;
        const plotHeight = height - padding.top - padding.bottom;

        if (trafficData.length < 2) {
            context.fillStyle = textColor;
            context.font = "14px system-ui, sans-serif";
            context.textAlign = "center";
            context.textBaseline = "middle";
            context.fillText("Collecting live traffic samples…", width / 2, height / 2);
            return;
        }

        const maximum = Math.max(...trafficData.flatMap(({ incoming, outgoing }) => [incoming, outgoing]));
        const ceiling = Math.max(10, Math.ceil(maximum / 10) * 10);
        const x = (index) => padding.left + index * plotWidth / (trafficData.length - 1);
        const y = (value) => padding.top + plotHeight - value / ceiling * plotHeight;

        context.font = "12px system-ui, sans-serif";
        context.textBaseline = "middle";
        context.lineWidth = 1;

        for (let tick = 0; tick <= 4; tick += 1) {
            const value = ceiling * tick / 4;
            const tickY = y(value);
            context.strokeStyle = "rgba(208, 196, 179, 0.18)";
            context.beginPath();
            context.moveTo(padding.left, tickY);
            context.lineTo(width - padding.right, tickY);
            context.stroke();
            context.fillStyle = textColor;
            context.textAlign = "right";
            context.fillText(String(Math.round(value)), padding.left - 8, tickY);
        }

        function drawSeries(key, color) {
            context.beginPath();
            trafficData.forEach((point, index) => {
                const pointX = x(index);
                const pointY = y(point[key]);
                if (index === 0) context.moveTo(pointX, pointY);
                else context.lineTo(pointX, pointY);
            });

            context.lineTo(x(trafficData.length - 1), y(0));
            context.lineTo(x(0), y(0));
            context.closePath();
            context.globalAlpha = 0.12;
            context.fillStyle = color;
            context.fill();
            context.globalAlpha = 1;

            context.beginPath();
            trafficData.forEach((point, index) => {
                const pointX = x(index);
                const pointY = y(point[key]);
                if (index === 0) context.moveTo(pointX, pointY);
                else context.lineTo(pointX, pointY);
            });
            context.strokeStyle = color;
            context.lineWidth = 2.5;
            context.lineJoin = "round";
            context.lineCap = "round";
            context.stroke();
        }

        drawSeries("incoming", incomingColor);
        drawSeries("outgoing", outgoingColor);

        context.fillStyle = textColor;
        context.textAlign = "center";
        trafficData.forEach((point, index) => {
            if (index % Math.ceil(trafficData.length / 6) === 0 || index === trafficData.length - 1) {
                context.fillText(point.time, x(index), height - padding.bottom / 2);
            }
        });
    }

    window.updateTrafficChart = (data) => {
        validateData(data);
        trafficData = data;
        drawTrafficChart();
    };

    new ResizeObserver(drawTrafficChart).observe(canvas);
    drawTrafficChart();
})();

(() => {
    const status = document.getElementById("overview-status");
    const metricCards = document.querySelectorAll("[data-metric]");
    if (!status || metricCards.length === 0) return;

    const trafficData = [];
    let requestPending = false;

    function formatNumber(value) {
        return Number(value).toFixed(1);
    }

    function renderMetric(name, value, statusText, percent) {
        const card = document.querySelector(`[data-metric="${name}"]`);
        if (!card) return;

        const valueElement = card.querySelector("[data-value]");
        const statusElement = card.querySelector("[data-status]");
        const meter = card.querySelector("[data-meter]");
        const progress = card.querySelector('[role="progressbar"]');

        valueElement.textContent = value === null ? "--" : formatNumber(value);
        statusElement.textContent = statusText;

        if (percent === null) {
            meter.style.width = "0%";
            progress.setAttribute("aria-valuetext", "Unavailable");
        } else {
            const boundedPercent = Math.max(0, Math.min(100, percent));
            meter.style.width = `${boundedPercent}%`;
            progress.setAttribute("aria-valuenow", formatNumber(boundedPercent));
            progress.setAttribute("aria-valuetext", `${formatNumber(boundedPercent)}%`);
        }
    }

    async function readMetrics() {
        if (requestPending) return;
        requestPending = true;

        try {
            const response = await fetch("pages/overview.php?metrics=1", {
                credentials: "same-origin",
                cache: "no-store"
            });
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || "Unable to load server telemetry.");
            }

            renderMetric(
                "cpu",
                result.cpuPercent,
                result.cpuPercent === null ? "Collecting first sample" : "Current usage",
                result.cpuPercent
            );
            renderMetric(
                "memory",
                result.memory?.usedGb ?? null,
                result.memory ? `${formatNumber(result.memory.totalGb)} GB total` : "Unavailable on this server",
                result.memory?.percent ?? null
            );
            renderMetric(
                "storage",
                result.storage?.usedGb ?? null,
                result.storage ? `${formatNumber(result.storage.totalGb)} GB total` : "Unavailable on this server",
                result.storage?.percent ?? null
            );
            renderMetric(
                "temperature",
                result.cpuTemperature,
                result.cpuTemperature === null ? "Not available from server sensors" : "Current temperature",
                result.cpuTemperature
            );

            if (result.network) {
                trafficData.push({
                    time: new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit", second: "2-digit" }),
                    incoming: result.network.incoming,
                    outgoing: result.network.outgoing
                });
                if (trafficData.length > 12) trafficData.shift();
                if (trafficData.length >= 2) window.updateTrafficChart(trafficData);
            }

            status.textContent = `Live · updated at ${new Date().toLocaleTimeString()}`;
        } catch (error) {
            status.textContent = error instanceof Error ? error.message : "Unable to load server telemetry.";
        } finally {
            requestPending = false;
        }
    }

    readMetrics();
    window.setInterval(readMetrics, 3000);
})();
