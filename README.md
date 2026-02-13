<!-- README.html -->

<h1>Recurring Billing System (Laravel + Livewire)</h1>

<p>
  A recurring billing platform built with <strong>Laravel</strong> and <strong>Livewire</strong>.
  It allows users to register their own clients, create periodic charges, and automate billing and collections.
  Payments are processed <strong>directly through the client’s own payment gateway</strong>, so the system does not charge any additional percentage-based usage fees.
</p>

<hr />

<h2>Key Features</h2>
<ul>
  <li><strong>Client management</strong>: register and manage customers in one place.</li>
  <li><strong>Recurring charges</strong>: configure billing cycles (weekly, monthly, yearly, etc.).</li>
  <li><strong>Automated billing</strong>: generate and send charges automatically based on schedule.</li>
  <li><strong>Gateway-owned processing</strong>: payments run through the client’s payment provider account.</li>
  <li><strong>No % usage fee</strong>: only the gateway’s standard fees apply.</li>
  <li><strong>Dashboard</strong>: track charge status (pending, paid, failed, overdue).</li>
</ul>

<h2>How It Works</h2>
<ol>
  <li>User creates an account and connects (or configures) a payment gateway provider.</li>
  <li>User registers clients and creates recurring billing plans/charges.</li>
  <li>The system schedules billing runs and triggers charges on the defined dates.</li>
  <li>Invoices/charges are sent automatically and payments are collected via the client’s gateway account.</li>
</ol>

<hr />

<h2>Tech Stack</h2>
<ul>
  <li><strong>Backend:</strong> Laravel</li>
  <li><strong>UI:</strong> Livewire (SPA-like experience without heavy JS)</li>
  <li><strong>Database:</strong> MySQL / MariaDB (or PostgreSQL)</li>
  <li><strong>Queues:</strong> Redis / Database (recommended for billing tasks)</li>
  <li><strong>Scheduler:</strong> Laravel Scheduler (cron) for recurring runs</li>
</ul>

<hr />

<h2>Requirements</h2>
<ul>
  <li>PHP 8.2+</li>
  <li>Composer</li>
  <li>Node.js 18+ (if using Vite/build tools)</li>
  <li>MySQL/MariaDB or PostgreSQL</li>
  <li>Redis (optional but recommended for queues)</li>
</ul>

<hr />

<h2>Installation</h2>

<h3>1) Clone</h3>
<pre><code>git clone &lt;your-repo-url&gt;
cd &lt;your-project-folder&gt;</code></pre>

<h3>2) Install Dependencies</h3>
<pre><code>composer install</code></pre>

<p>If your project uses frontend assets:</p>
<pre><code>npm install
npm run build</code></pre>

<h3>3) Environment Setup</h3>
<pre><code>cp .env.example .env
php artisan key:generate</code></pre>

<h3>4) Configure Database</h3>
<p>Edit <code>.env</code> and set:</p>
<pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password</code></pre>

<h3>5) Run Migrations</h3>
<pre><code>php artisan migrate</code></pre>

<h3>6) (Optional) Seed Data</h3>
<pre><code>php artisan db:seed</code></pre>

<hr />

<h2>Running the App</h2>

<h3>Development Server</h3>
<pre><code>php artisan serve</code></pre>

<p>Then open: <code>http://127.0.0.1:8000</code></p>

<hr />

<h2>Queues & Scheduler (Important for Recurring Billing)</h2>

<h3>Queue Worker</h3>
<p>Recommended so billing and webhook processing run reliably:</p>
<pre><code>php artisan queue:work</code></pre>

<h3>Scheduler (Cron)</h3>
<p>Set up a cron job to run Laravel Scheduler every minute:</p>
<pre><code>* * * * * cd /path-to-your-project &amp;&amp; php artisan schedule:run &gt;&gt; /dev/null 2&gt;&amp;1</code></pre>

<hr />

<h2>Payment Gateway Integration</h2>

<p>
  This project is designed so billing is performed directly through the <strong>client’s own gateway account</strong>.
  The system orchestrates charge creation, scheduling, notifications, and reconciliation, but it does not add a usage fee percentage.
</p>

<ul>
  <li>Configure gateway credentials in <code>.env</code> (provider-specific)</li>
  <li>Set webhook endpoints (provider-specific)</li>
  <li>Enable queue processing for webhook events</li>
</ul>

<p><em>Note:</em> Gateway setup varies by provider (Stripe, Asaas, Mercado Pago, etc.).</p>

<hr />

<h2>Project Structure (Suggested)</h2>
<ul>
  <li><code>app/Domain/Billing</code> — billing domain logic</li>
  <li><code>app/Jobs</code> — recurring charge jobs</li>
  <li><code>app/Http/Livewire</code> — Livewire components</li>
  <li><code>routes/web.php</code> — UI routes</li>
  <li><code>routes/api.php</code> — webhooks & API endpoints</li>
</ul>

<hr />

<h2>Roadmap</h2>
<ul>
  <li>Multi-gateway support (pluggable providers)</li>
  <li>Retry logic for failed payments</li>
  <li>Dunning emails (reminders for overdue charges)</li>
  <li>Multi-tenant support</li>
  <li>Role-based access control</li>
  <li>Invoice PDF export</li>
</ul>

<hr />

<h2>Contributing</h2>
<ol>
  <li>Fork the repository</li>
  <li>Create a feature branch: <code>git checkout -b feature/my-feature</code></li>
  <li>Commit changes: <code>git commit -m "Add my feature"</code></li>
  <li>Push: <code>git push origin feature/my-feature</code></li>
  <li>Open a Pull Request</li>
</ol>

<hr />

<h2>License</h2>
<p>
  Add your preferred license here (e.g., MIT, Apache-2.0, proprietary).
</p>

<hr />

<h2>Contact</h2>
<p>
  If you want, add contact links here (website, email, Link
