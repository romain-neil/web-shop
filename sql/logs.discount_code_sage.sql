CREATE VIEW logs.discount_usage
AS
    SELECT
        usage.id AS id,
        usage.date_usage AS date_code_used,

        -- related order
        o.date_created AS date_order_created,

        -- related customer
        CONCAT("user".prenom, ' ', UPPER("user".nom)) AS customer_name
    FROM
        shop.discount_code_usage AS usage
    LEFT JOIN shop.order AS o ON o.id = usage.order_id
    LEFT JOIN intranet.customer AS cust ON cust.id = o.customer_id
    LEFT JOIN intranet."user" AS "user" ON "user".id = cust.id
;
