-- adding necessary tables data

-- adding data to customer type table
INSERT INTO `customer_types` (`id`, `customerType`, `created_at`, `updated_at`) VALUES
(1, 'Labor', NULL, NULL),
(2, 'Cleaner', NULL, NULL),
(3, 'Security', NULL, NULL),
(4, 'Staff', NULL, NULL),
(5, 'Salesman', NULL, NULL),
(6, 'Technician', NULL, NULL),
(7, 'Manager', NULL, NULL);

-- adding data to user Roles table

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Owner', NULL, NULL),
(3, 'Manager', NULL, NULL),
(4, 'Client', NULL, NULL),
(5, 'Assistant Manager', NULL, NULL),
(6, 'Engineer', NULL, NULL),
(7, 'Accountant', NULL, NULL),
(8, 'Technician', NULL, NULL),
(9, 'Salesman', NULL, NULL),
(10, 'Intern', NULL, NULL);


-- add first user as admin
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Chinthana', 'chinthana144@gmail.com', NULL, '$2y$12$C9dr2DhMLZMJyFa/paM5wuNKkmNiRxgZJXEeku7g7DupQyAXKhKCy', 1, NULL, '2025-03-20 06:11:11', '2025-03-20 06:11:11');
