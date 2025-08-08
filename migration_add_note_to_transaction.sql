-- This script modifies the database schema to support linking notes to transactions.
--
-- Step 1: Adds a `transaction_id` column to the `notes` table.
-- This column will be used to create a foreign key relationship to the `transactions` table.
-- It is nullable because some notes may not be associated with any transaction.
--
-- Step 2: Adds the foreign key constraint.
-- `ON DELETE CASCADE` is used to ensure that if a transaction is deleted,
-- the associated note is automatically deleted as well, preventing orphaned data.

ALTER TABLE `notes`
ADD COLUMN `transaction_id` INT(11) NULL DEFAULT NULL,
ADD CONSTRAINT `fk_note_transaction`
  FOREIGN KEY (`transaction_id`)
  REFERENCES `transactions`(`id`)
  ON DELETE CASCADE;

-- Note on Uniqueness:
-- To ensure that each transaction has at most one note, we would ideally add a UNIQUE
-- constraint on the `transaction_id` column. However, standard UNIQUE constraints in
-- many versions of MySQL/MariaDB do not allow multiple NULL values, which is required
-- for general-purpose notes that are not linked to any transaction.
--
-- Example of a simple unique constraint (NOT USED for compatibility reasons):
-- -- ALTER TABLE `notes` ADD UNIQUE (`transaction_id`);
--
-- Therefore, the one-to-one relationship will be enforced in the application logic
-- (the PHP code) when creating or updating notes, which is a more flexible and
-- portable solution.
