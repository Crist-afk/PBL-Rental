import { expect, test } from '@playwright/test';

const customer = {
    email: process.env.E2E_CUSTOMER_EMAIL ?? 'user@cosrent.com',
    password: process.env.E2E_CUSTOMER_PASSWORD ?? 'password123',
};

const admin = {
    email: process.env.E2E_ADMIN_EMAIL ?? 'admin@cosrent.com',
    password: process.env.E2E_ADMIN_PASSWORD ?? 'password123',
};

async function login(page, { email, password }) {
    await page.goto('/login');
    await page.locator('input[name="email"]').fill(email);
    await page.locator('input[name="password"]').fill(password);
    await page.locator('form').getByRole('button', { name: /^Login$/ }).click();
}

test.describe('CosRent smoke test', () => {
    test('guest can open main public pages', async ({ page }) => {
        const pages = [
            { path: '/', heading: /Bring Your Dream/i },
            { path: '/product', heading: /Product Catalog/i },
            { path: '/forum', heading: /Community Forum/i },
            { path: '/contact', heading: /Contact CosRent/i },
        ];

        for (const publicPage of pages) {
            const response = await page.goto(publicPage.path);

            expect(response?.ok()).toBeTruthy();
            await expect(page.getByText(publicPage.heading).first()).toBeVisible();
        }
    });

    test('customer can login', async ({ page }) => {
        await login(page, customer);

        await expect(page).toHaveURL(/\/dashboard$/);
        await expect(page.getByText(/Dashboard Area/i)).toBeVisible();
        await expect(page.getByText(/Customer Menu/i)).toBeVisible();
    });

    test('admin can login and open forum moderation', async ({ page }) => {
        await login(page, admin);

        await expect(page).toHaveURL(/\/admin\/dashboard$/);
        await expect(page.getByRole('heading', { name: /^Dashboard$/ })).toBeVisible();

        await page.goto('/admin/forum');
        await expect(page).toHaveURL(/\/admin\/forum$/);
        await expect(page.getByRole('heading', { name: /Forum Moderation/i })).toBeVisible();
    });

    test('home popular picks displays products from database', async ({ page }) => {
        await page.goto('/');

        const popularPicks = page.locator('section', {
            has: page.getByRole('heading', { name: /Popular Picks/i }),
        });

        await expect(popularPicks).toBeVisible();
        await expect(popularPicks.getByText(/No Costumes Yet/i)).toHaveCount(0);
        await expect(popularPicks.getByRole('link', { name: /Costume Details/i }).first()).toBeVisible();
    });
});
