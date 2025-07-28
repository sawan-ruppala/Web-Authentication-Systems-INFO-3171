from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# === Chrome Setup for MAXIMUM BOT SUSPICION ===
options = Options()
options.add_argument("--headless=new")  # Headless = bot
options.add_argument("--disable-blink-features=AutomationControlled")
options.add_argument("--disable-gpu")
options.add_argument("--no-sandbox")
options.add_argument("--disable-dev-shm-usage")
options.add_argument("--disable-extensions")
options.add_argument("--user-agent=Googlebot/2.1 (+http://www.google.com/bot.html)")
options.add_experimental_option("excludeSwitches", ["enable-automation"])
options.add_experimental_option("useAutomationExtension", False)

# Start Chrome
driver = webdriver.Chrome(options=options)

try:
    for attempt in range(3):
        print(f"\n[Attempt #{attempt + 1}] Visiting login page...")
        driver.get("http://localhost/project/auth0_login.php")

        # === Inject fake bot fingerprints ===
        driver.execute_script("Object.defineProperty(navigator, 'webdriver', {get: () => true})")
        driver.execute_script("window.chrome = { runtime: {} };")
        driver.execute_script("""
            Object.defineProperty(navigator, 'plugins', {
                get: () => [1, 2, 3]
            });
        """)
        driver.execute_script("""
            Object.defineProperty(navigator, 'languages', {
                get: () => ['xx-bot']
            });
        """)

        try:
            WebDriverWait(driver, 5).until(
                EC.presence_of_element_located((By.NAME, "email"))
            )

            email_field = driver.find_element(By.NAME, "email")
            password_field = driver.find_element(By.NAME, "password")

            email_field.clear()
            password_field.clear()

            # === Enter suspicious OR real credentials ===
            email_field.send_keys("sawanlazer124@gmail.com")  # Use real or test email
            password_field.send_keys("Mineblox12!#")

            driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
            print("Login form submitted.")

        except Exception as e:
            print("❌ Could not find login form. Blocked by Bot Detection.")
            print("Error:", e)

        time.sleep(1)

finally:
    print("\n✅ Done. Closing browser...")
    driver.quit()
