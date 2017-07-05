@fixture-CustomerUserAddressFixture.yml
Feature: grid views management on datagrids
  As Frontend User
  I need to create and use grid view on some grid

  Scenario: Create new default grid view with changed filter
    Given I signed in as AmandaRCole@example.org on the store frontend
    And I click "Account"
    And I click "Address Book"
    And I hide filter "State" in "Customer Company Addresses Grid" grid
    When I click grid view list on "Customer Company Addresses Grid" grid
    And I click "Save As New"
    And I set "Test view" as grid view name for "Customer Company Addresses Grid" grid on frontend
    And I mark Set as Default on grid view for "Customer Company Addresses Grid" grid on frontend
    And I click "Add"
    Then I should see "View has been successfully created" flash message
    And I should see a "Customer Company User Addresses Grid View List" element

  Scenario: Make sure gridview can be renamed few times
    When I click "Rename"
    And I set "Test view 01" as grid view name for "Customer Company Addresses Grid" grid on frontend
    And I click "Save"
    Then I should see "View has been successfully updated" flash message
    When I click "Customer Company Addresses Grid View List Close Button"
    Then I should see "Test view 01"
    When I click grid view list on "Customer Company Addresses Grid" grid
    And I click "Rename"
    And I set "Test view 02" as grid view name for "Customer Company Addresses Grid" grid on frontend
    And I click "Save"
    Then I should see "View has been successfully updated" flash message
    When I click "Customer Company Addresses Grid View List Close Button"
    Then I should see "Test view 02"