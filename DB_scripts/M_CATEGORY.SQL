CREATE TABLE M_Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL,
    category_desc TEXT,
    category_img VARCHAR(255),
    parent_id INT DEFAULT 0,
    level INT DEFAULT 0,
    created_by VARCHAR(100) NOT NULL,
    modified_by VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    delflag CHAR(1) DEFAULT 'N', -- 'Y' for deleted, 'N' for not deleted
    status CHAR(1) DEFAULT 'N', -- 'Y' for active, 'N' for inactive
  --  FOREIGN KEY (parent_id) REFERENCES M_Categories(category_id)
);




-- sp for category
--ls_M_cat --start
DELIMITER //

CREATE PROCEDURE LS_M_Cat()
BEGIN
    SELECT 
        category_id,
        category_name,
        category_desc,
        category_img,
        parent_id,
        level,
        created_by,
        modified_by,
        created_at,
        modified_at,
        delflag,
        status
    FROM M_Categories
    WHERE delflag = 'N'; -- Only list non-deleted M_Categories
END //

DELIMITER ;
--Ls_M_Cat -- End


--DISP_M_Cat Start
DELIMITER //

CREATE PROCEDURE DISP_M_Cat(IN p_category_id INT)
BEGIN
    SELECT 
        category_id,
        category_name,
        category_desc,
        category_img,
        parent_id,
        level,
        created_by,
        modified_by,
        created_at,
        modified_at,
        delflag,
        status
    FROM M_Categories
    WHERE category_id = p_category_id
      AND delflag = 'N'; -- Only display non-deleted category
END //

DELIMITER ;

--DISP_M_Cat End
--DEL_M_Cat Start

DELIMITER //

CREATE PROCEDURE DEL_M_Cat(IN p_category_id INT)
BEGIN
    UPDATE M_Categories
    SET delflag = 'Y' -- Mark as deleted
    WHERE category_id = p_category_id;
END //

DELIMITER ;


--DEL_M_Cat End
--IU_M_cat -- Start
DELIMITER //
CREATE PROCEDURE IU_M_Cat(
    IN p_AEFLAG CHAR(1),
    IN p_cat_id INT,
    IN p_cat_name VARCHAR(255),
    IN p_cat_desc TEXT,
    IN p_parent_id INT,
    IN p_cat_img VARCHAR(255),
    IN p_created_by INT,
    IN p_modified_by INT,
    IN p_delflag CHAR(1),
    IN p_status CHAR(1)
)
BEGIN
    DECLARE v_level INT;
    DECLARE v_parent_exists INT;

    -- Check if parent category exists
    IF p_parent_id IS NOT NULL AND p_parent_id <> 0 THEN
        SELECT COUNT(*) INTO v_parent_exists
        FROM M_Categories
        WHERE category_id = p_parent_id;
        
        -- If parent does not exist, raise an error
        IF v_parent_exists = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Parent category does not exist';
        END IF;
    END IF;

    -- Determine the level based on parent ID
    IF p_parent_id IS NULL OR p_parent_id = 0 THEN
        SET v_level = 1; -- Top-level category
    ELSE
        -- Find the level of the parent category
        SELECT level + 1 INTO v_level
        FROM M_Categories
        WHERE category_id = p_parent_id;
        
        -- If level cannot be determined, raise an error
        IF v_level IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Could not determine level for the given parent category';
        END IF;
    END IF;

    IF p_AEFLAG = 'A' THEN
        -- Insert new category
        INSERT INTO M_Categories (
            category_name, category_desc, parent_id, category_img, created_by, modified_by, delflag, status, level
        ) VALUES (
            p_cat_name, p_cat_desc, p_parent_id, p_cat_img, p_created_by, p_modified_by, p_delflag, p_status, v_level
        );
    ELSEIF p_AEFLAG = 'E' THEN
        -- Update existing category
        UPDATE M_Categories
        SET
            category_name = p_cat_name,
            category_desc = p_cat_desc,
            parent_id = p_parent_id,
            category_img = p_cat_img,
            modified_by = p_modified_by,
            delflag = p_delflag,
            status = p_status,
            level = v_level
        WHERE
            category_id = p_cat_id;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid AEFLAG value';
    END IF;
END //
DELIMITER ;

--IU_M_cat -- End