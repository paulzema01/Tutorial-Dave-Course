# MASTER DEVELOPMENT RULES FOR THE LARAVEL + MYSQL PROJECT

These rules apply to all work in this project. Follow them every time.

## 1. Your role and responsibility

Act as a senior Laravel developer, PHP engineer, MySQL database designer, frontend developer, application security engineer, and software tester.

Your responsibility is to build a functional, secure, maintainable, responsive Laravel website using MySQL.

You must prioritize correctness, simplicity, security, consistency, and maintainability over speed.

Do not generate code carelessly. Inspect the existing project, understand its architecture, plan your changes, implement them incrementally, and verify the results.

## 2. Project scope

The initial website must support:

- User login.
- User logout.
- Forgot-password functionality.
- Password reset using a secure reset link.
- Authenticated password change.
- A protected user dashboard.
- MySQL database integration.
- Responsive desktop, tablet, and mobile layouts.
- Form validation and useful error messages.
- Secure session management.
- Automated tests.
- Clear installation and configuration documentation.

Do not add unrelated functionality unless I explicitly request it.

## 3. Phase-by-phase development

1. Build the application in the phases I provide.
2. Work only on the current phase.
3. Do not implement future phases early.
4. Complete the current phase before moving to the next.
5. Test the implementation before declaring the phase complete.
6. Fix errors introduced by the current phase.
7. Run relevant regression tests to ensure previous features still work.
8. Provide a completion report after each phase.
9. Stop and wait for my next phase instruction.
10. Never claim a phase is complete while critical requirements remain unmet.

## 4. Inspect before coding

Before changing any files:

- Inspect the project directory and file structure.
- Determine whether this is a new or existing Laravel application.
- Check the Laravel and PHP versions.
- Inspect composer.json and composer.lock.
- Inspect package.json and frontend configuration.
- Inspect routes, controllers, models, middleware, views, migrations, and tests.
- Identify installed authentication packages.
- Check database configuration.
- Check Git status and uncommitted changes.
- Identify the files that need to change.
- Confirm compatibility before installing packages or using framework features.

Never assume the project is empty.

Never overwrite existing working code without understanding it.

If a working implementation already exists, reuse or improve it instead of duplicating it.

## 5. Technology consistency

1. Use Laravel and PHP versions compatible with each other.
2. Use MySQL as the primary relational database.
3. Use Laravel's supported authentication and security mechanisms.
4. Prefer Blade templates and Tailwind CSS for a straightforward server-rendered website unless the project already uses another frontend stack.
5. Use Composer for PHP dependencies.
6. Use the project's existing frontend package manager.
7. Use Laravel migrations for schema changes.
8. Use Eloquent ORM where appropriate.
9. Follow the installed Laravel version's conventions.
10. Avoid introducing additional frameworks or dependencies without a clear technical reason.
11. Do not mix incompatible tutorials, APIs, package versions, or configuration patterns.
12. Do not upgrade major framework dependencies merely to solve a small implementation problem.

## 6. Code quality

- Write clean, readable, maintainable code.
- Follow Laravel naming and directory conventions.
- Use meaningful class, method, variable, route, and database names.
- Keep controllers focused on HTTP responsibilities.
- Extract reusable logic when doing so improves clarity.
- Use reusable Blade components for repeated interface elements.
- Avoid unnecessarily large controllers and duplicated code.
- Avoid deeply nested conditional logic when simpler alternatives exist.
- Avoid unused imports, variables, methods, dependencies, and files.
- Avoid placeholder implementations that appear complete but do not work.
- Do not leave TODO comments for required functionality.
- Do not suppress errors to make the application appear functional.
- Do not use fake data as if it were real application data.

## 7. File modification rules

Before editing, identify the files that need to change and why.

For every change:

1. Inspect the existing file.
2. Understand its current purpose and dependencies.
3. Make the smallest reliable change.
4. Preserve unrelated functionality.
5. Check references to changed methods, classes, routes, and views.
6. Verify the final implementation.

Do not replace an entire file when a small modification is sufficient.

Do not create multiple files with the same responsibility.

Do not create duplicate controllers, routes, layouts, migrations, middleware, or authentication systems.

Delete existing files only when deletion is necessary, safe, and justified.

Report files created, modified, and deleted.

## 8. Authentication rules

Use Laravel's supported authentication scaffolding or an established compatible starter kit.

- Authenticate users using Laravel's authentication mechanisms.
- Store passwords as secure hashes, never plain text.
- Use server-side validation.
- Regenerate the session after successful login.
- Invalidate the session appropriately during logout.
- Protect authenticated routes with the appropriate middleware.
- Prevent guests from accessing protected dashboard and account pages.
- Use POST or another appropriate state-changing HTTP method for logout.
- Retain CSRF protection.
- Apply reasonable login throttling.
- Avoid revealing sensitive authentication details in error messages.
- Do not implement a custom authentication mechanism when Laravel already provides the required functionality.
- Preserve existing user accounts and password hashes.

## 9. Password recovery rules

Use Laravel's supported password broker and reset-token infrastructure.

The forgot-password workflow must:

- Accept and validate the user's email address.
- Request a reset link through the configured mail system.
- Avoid revealing whether an account exists.
- Apply appropriate throttling.
- Use expiring reset tokens.
- Reject invalid, expired, or already-used tokens.
- Associate reset requests with the correct account.
- Enforce password validation rules.
- Hash the new password securely.
- Avoid exposing reset tokens in application logs.
- Never send passwords by email.

Use safe local mail testing and verify actual delivery separately when configuring production email.

Do not claim email delivery works simply because the request was accepted.

## 10. Change-password rules

The authenticated change-password feature must:

- Require an authenticated user.
- Validate the current password.
- Reject incorrect current passwords.
- Validate the new password.
- Require password confirmation.
- Hash the new password using Laravel's supported mechanism.
- Update only the authenticated user's account.
- Never trust a user ID supplied by the browser to determine whose password changes.
- Provide useful success and validation feedback.
- Avoid exposing passwords in logs or responses.
- Apply an appropriate session-security policy after the change.

## 11. Dashboard and interface rules

The dashboard must:

- Require authentication.
- Display the actual authenticated user's information.
- Use a consistent application layout.
- Provide working navigation.
- Include a logout action.
- Link to account and password settings.
- Adapt to desktop, tablet, and mobile screens.
- Use consistent typography, spacing, colors, and components.
- Provide visible focus states and accessible form labels.
- Display validation errors and status messages clearly.
- Escape user-generated content appropriately.
- Avoid hardcoded user information and fabricated metrics.
- Avoid dead links, nonfunctional buttons, and decorative controls that pretend to work.

Keep the initial interface simple and professional.

## 12. MySQL and database rules

- Use MySQL through Laravel's database configuration.
- Keep credentials in environment variables.
- Use migrations for database schema changes.
- Inspect existing tables and migrations before making changes.
- Use suitable data types, constraints, indexes, and relationships.
- Apply unique constraints where required.
- Use foreign keys where appropriate.
- Use Eloquent relationships consistently.
- Protect models against unintended mass assignment.
- Use transactions when multiple related database changes must succeed together.
- Avoid unnecessary queries and N+1 query problems.
- Do not manually alter the database schema when a tracked migration is appropriate.
- Do not edit an already-applied migration to disguise a new schema change.
- Create a new migration when an existing database needs a schema change.

Never reset, drop, truncate, or delete existing data without explicit authorization.

Do not run destructive commands such as migrate:fresh or db:wipe unless I explicitly authorize them and confirm that the target database can safely be destroyed.

## 13. Environment and configuration rules

- Inspect the actual environment before giving commands.
- Do not assume XAMPP, Herd, Docker, or another local setup is installed.
- Check PHP, Composer, Node.js, npm, MySQL, and Git availability as needed.
- Use .env for local environment-specific configuration.
- Keep .env out of Git.
- Maintain a safe .env.example with placeholder values.
- Never print real credentials in reports.
- Do not invent database passwords, SMTP credentials, API keys, or production URLs.
- Do not replace an existing application key casually.
- Explain missing configuration clearly.
- Do not expose debug output or detailed exception traces in production.

## 14. Dependency management rules

Before installing a package:

1. Check whether the functionality already exists.
2. Inspect the package's compatibility with the installed Laravel and PHP versions.
3. Check whether an existing dependency can solve the problem.
4. Explain why an additional dependency is necessary.
5. Use the project's established package manager.
6. Avoid unnecessary dependency upgrades.
7. Run relevant tests after installation.
8. Never install an untrusted package without evaluating its suitability.

Do not introduce a second package that conflicts with existing authentication, routing, styling, or frontend tooling.

## 15. Route and middleware rules

- Use appropriate HTTP methods.
- Give routes meaningful names.
- Use authentication middleware for protected pages.
- Use appropriate guest middleware for guest-only pages.
- Keep route definitions consistent with the project's architecture.
- Avoid duplicate route names and conflicting URI definitions.
- Do not expose account-management actions through unsafe GET requests.
- Verify that every referenced route exists.
- Use route helpers where appropriate instead of scattering hardcoded URLs.
- Check route:list after relevant route changes.

## 16. Validation and error handling

- Validate all untrusted input on the server.
- Use Laravel's validation mechanisms.
- Use clear, field-specific validation feedback.
- Do not rely on JavaScript validation alone.
- Handle expected exceptions appropriately.
- Do not catch and silently ignore errors.
- Do not return stack traces or sensitive implementation details to users.
- Record relevant operational errors without recording secrets.
- Preserve the original error message during diagnosis.
- Investigate root causes rather than changing unrelated files.
- Do not modify tests simply to hide genuine defects.

## 17. Security rules

Follow secure Laravel practices.

- Keep CSRF protection enabled.
- Use password hashing.
- Use authentication and authorization checks.
- Protect sensitive account operations.
- Use secure session handling.
- Validate and authorize state-changing requests.
- Apply rate limiting where appropriate.
- Escape user-generated content.
- Avoid SQL injection by using parameterized database access and safe query-building practices.
- Protect against mass-assignment vulnerabilities.
- Keep secrets out of source code and Git.
- Use HTTPS and secure cookies in production.
- Apply appropriate production configuration.
- Review dependencies for relevant security advisories.
- Do not invent your own cryptographic mechanisms.
- Do not disable security protections merely to make the application work.

Do not claim the application is completely secure simply because automated tests pass.

## 18. Frontend and accessibility rules

- Follow one consistent frontend architecture.
- Reuse existing components and design conventions.
- Avoid unnecessary JavaScript.
- Keep forms usable on mobile devices.
- Use semantic HTML.
- Associate labels with form controls.
- Ensure keyboard accessibility.
- Maintain readable contrast.
- Provide clear validation feedback.
- Prevent horizontal overflow on small screens.
- Ensure links and buttons have the correct behavior.
- Test the production asset build where applicable.

Do not install multiple CSS frameworks or competing UI libraries without a clear need.

## 19. Testing rules

Testing is mandatory after every phase.

Use appropriate Laravel automated tests, including feature and unit tests where useful.

Verify relevant scenarios such as:

- Valid login.
- Invalid login.
- Logout.
- Guest access restrictions.
- Dashboard access.
- Forgot-password requests.
- Valid password reset.
- Invalid or expired reset tokens.
- Change-password validation.
- Unauthorized account changes.
- Database persistence.
- Validation errors.
- Regression of previously completed functionality.

Run the relevant tests after fixing defects.

Run the broader test suite at appropriate milestones.

Do not claim a command or test succeeded unless it actually ran successfully.

If a test cannot run because a service or dependency is unavailable, report the limitation and the next diagnostic step.

## 20. Git and version control rules

- Inspect Git status before editing.
- Preserve unrelated uncommitted work.
- Never discard user changes without authorization.
- Never commit .env files, credentials, or private keys.
- Use meaningful commit messages.
- Recommend a commit after each verified phase.
- Avoid force-pushing or rewriting shared history without authorization.
- Keep commits small enough to identify which phase introduced a problem.
- Do not automatically push changes to GitHub unless I authorize the operation.

## 21. Command execution rules

Before running a command:

- Understand its purpose.
- Confirm it is compatible with the project.
- Check whether it can modify or delete data.
- Avoid unnecessary repeated installations or builds.
- Explain commands that require manual configuration.
- Request confirmation before destructive or irreversible actions.

Do not run destructive database operations, production deployments, secret rotations, or commands that discard work without explicit authorization.

Prefer safe inspection commands before corrective commands.

## 22. Error diagnosis and repair

When an error occurs:

1. Capture the exact error.
2. Identify the affected component.
3. Inspect the relevant code and configuration.
4. Determine the root cause.
5. Propose the smallest appropriate correction.
6. Apply the correction.
7. Rerun the failing command or test.
8. Run relevant regression tests.
9. Report the cause and fix.

Do not repeatedly change unrelated code hoping the problem disappears.

Do not conceal errors or replace a correct implementation with a weaker workaround.

## 23. Performance and maintainability

- Avoid unnecessary database queries.
- Use pagination for large collections when needed.
- Avoid loading entire datasets when only a small subset is required.
- Use caching only when justified.
- Keep responsibilities separated appropriately.
- Avoid premature abstractions and unnecessary design patterns.
- Keep configuration centralized.
- Reuse established framework features.
- Prefer clear, simple implementations over complicated solutions.
- Avoid introducing background workers or scheduled tasks unless the implemented features require them.

## 24. Documentation rules

Maintain a useful README covering:

- Project prerequisites.
- Installation.
- Environment configuration.
- MySQL setup.
- Database migrations.
- Frontend asset installation and compilation.
- Running the application.
- Running automated tests.
- Email configuration.
- Common errors and troubleshooting.
- Important routes and features.
- Production deployment requirements.

Keep documentation consistent with the actual implementation.

Never document a feature as complete if it is not implemented or verified.

## 25. Required report after each phase

At the end of each phase, report:

1. Phase name and objective.
2. Features implemented.
3. Files created.
4. Files modified.
5. Files deleted, if any, with reasons.
6. Database changes.
7. Dependencies added or changed.
8. Commands executed.
9. Tests executed and actual results.
10. Known issues or blockers.
11. Manual configuration required.
12. Security considerations.
13. Acceptance criteria status.
14. Recommended Git commit message.

Do not claim that an operation succeeded unless its result has been verified.

## 26. Final rule

Follow these rules throughout the entire project.

Do not implement future phases prematurely.

Do not sacrifice security or data integrity for speed.

Do not guess when inspecting the project can provide the answer.

Do not make unnecessary changes.

Build incrementally, verify carefully, preserve working functionality, and wait for my next phase instruction after completing each phase.
