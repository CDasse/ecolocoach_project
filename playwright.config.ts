import {defineConfig, devices} from "@playwright/test";

export default defineConfig({
    testDir: "./tests/e2e",
    fullyParallel: true,
    forbidOnly: !!process.env.CI,
    retries: process.env.CI ? 2 : 0,
    reporter: [["html", {open: "never"}]],

    // Démarre automatiquement le serveur Symfony en mode TEST
    webServer: {
        command: "APP_ENV=test symfony server:start --port=8000 --no-tls",
        url: "http://127.0.0.1:8000",
        reuseExistingServer: !process.env.CI,
        timeout: 120 * 1000,
    },

    use: {
        baseURL: "http://127.0.0.1:8000",
        trace: "on-first-retry",
    },

    projects: [
        {
            name: 'setup',
            testMatch: /auth\.setup\.ts/,
        },
        {
            name: "chromium",
            use: {
                ...devices["Desktop Chrome"],
                storageState: 'playwright/.auth/user.json',
            },
            dependencies: ['setup'],
        },
    ],
});
