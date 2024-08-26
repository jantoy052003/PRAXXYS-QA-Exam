import { test, expect } from '@playwright/test';

test('Validate if user can login and logout successfully', async ({page}) => {
   await page.goto('http://127.0.0.1:8000/login');
   await page.getByPlaceholder('Email').click();
   await page.getByPlaceholder('Email').fill('mayert.scot@example.com');
   await page.getByPlaceholder('Password').click();
   await page.getByPlaceholder('Password').fill('password');
   await page.getByRole('button', { name: 'Sign In' }).click();
   await expect(page.locator("h1")).toHaveText("Products");
   await page.getByRole('link', { name: ' Logout' }).click();
   await expect(page.locator("button")).toHaveText("Sign In");
})