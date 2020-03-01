# Oro\Bundle\CustomerBundle\Entity\CusOrganiztion

## ACTIONS

### get

Retrieve a specific customer user address record.

{@inheritdoc}

### get_list

Retrieve a collection of customer user address records.

{@inheritdoc}

{@request:json_api}
Example:

```JSON
{  
   "data":
  {
      "type": "cus_organiztions",
      "attributes": {
        "cus_status": 3
      },
      "relationships": {
        "customer": {
          "data": {
            "type": "customers",
            "id": "1"
          }
        },
        "organiztion": {
          "data": {
            "type": "organizations",
            "id": "1"
          }
        }
      }
    }
}