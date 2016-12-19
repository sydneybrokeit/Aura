require 'test_helper'

class ResultControllerTest < ActionController::TestCase
  test "should get load" do
    get :load
    assert_response :success
  end

end
