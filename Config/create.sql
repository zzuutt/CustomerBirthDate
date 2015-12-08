
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- customer_birth_date
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `customer_birth_date`
(
    `id` INTEGER NOT NULL,
    `birth_date` DATE NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_customer_birthdate_id`
        FOREIGN KEY (`id`)
        REFERENCES `customer` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
