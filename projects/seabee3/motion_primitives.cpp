// =============================================================================================================================================
//! A 3D position
class Position
{
public:
    double x_;
    double y_;
    double z_;

    Position()
    :
        x_( 0 ),
        y_( 0 ),
        z_( 0 )
    {
        //
    }

    Position( double const & x, double const & y, double const & z )
    :
        x_( x ),
        y_( y ),
        z_( z )
    {
        //
    }

    // ##[ Operators ]##########################################################################################################################
    Position operator+( Position const & other ) const
    {
        return Position
        (
            x_ + other.x_,
            y_ + other.y_,
            z_ + other.z_
        );
    }

    Position & operator+=( Position const & other )
    {
        x_ += other.x_;
        y_ += other.y_;
        z_ += other.z_;

        return *this;
    }
};

// =============================================================================================================================================
//! An orientation
class Orientation
{
public:
    double yaw_;

    Orientation()
    :
        yaw_( 0 )
    {
        //
    }

    Orientation( double const & yaw )
    :
        yaw_( yaw )
    {
        //
    }

    // ##[ Operators ]##########################################################################################################################
    Orientation operator+( Orientation const & other ) const
    {
        return Orientation( yaw_ + other.yaw_ );
    }

    Orientation & operator+=( Orientation const & other )
    {
        yaw_ += other.yaw_;
        return *this;
    }
};

// =============================================================================================================================================
//! The combined Position and Orientation of a Landmark
class Pose
{
public:
    Position position_;
    Orientation orientation_;

    template<class... __Args>
    Pose( __Args&&... args )
    {
        init( std::forward<__Args>( args )... );
    }

    // ##[ Operators ]##########################################################################################################################
    Pose operator+( Position const & other ) const
    {
        return Pose( position_ + other.position_ );
    }

    Pose & operator+=( Position const & other )
    {
        position_ += other;

        return *this;
    }

    Pose operator+( Orientation const & other ) const
    {
        return Pose( orientation_ + other.orientation_ );
    }

    Pose & operator+=( Orientation const & other )
    {
        orientation_ += other;

        return *this;
    }

    Pose operator+( Pose const & other ) const
    {
        return Pose( position_ + other.position_, orientation_ + other.orientation_ );
    }

    Pose & operator+=( Pose const & other )
    {
        operator+=( other.position );
        operator+=( other.orientation_ );

        return *this;
    }

    // ##[ Initialization ]#####################################################################################################################
    template<class... __Args>
    void init( Position const & position, __Args&&... args )
    {
        position_ = position;
        init( std::forward<__Args>( args )... );
    }

    template<class... __Args>
    void init( Orientation const & orientation, __Args&&... args )
    {
        orientation_ = orientation;
        init( std::forward<__Args>( args )... );
    }

    void init() const {}
};

// =============================================================================================================================================
class Landmark
{
public:
    Pose pose_;

    enum LandmarkType
    {
        GATE,
        BUOY,
        PIPE,
        HEDGE,
        WINDOW,
        BIN,
        PINGER
    };

    LandmarkType type_;
    Color color_;

    template<class... __Args>
    Landmark( __Args&&... args )
    {
        init( std::forward<__Args>( args )... );
    }

    // ##[ Initialization ]#####################################################################################################################
    template<class... __Args>
    void init( std::string const & name, __Args&&... args )
    {
        name_ = name;
        init( std::forward<__Args>( args )... );
    }

    template<class... __Args>
    void init( LandmarkType const & type, __Args&&... args )
    {
        type_ = type;
        init( std::forward<__Args>( args )... );
    }

    template<class... __Args>
    void init( Color const & name, __Args&&... args )
    {
        color_ = color;
        init( std::forward<__Args>( args )... );
    }

    void init() const {}
};

// =============================================================================================================================================
class Buoy : public Landmark
{
public:
    template<class... __Args>
    Buoy( __Args&&... args )
    :
        Landmark( Landmark::BUOY, std::forward<__Args>( args )... )
    {
        //
    }
};

// =============================================================================================================================================
class Pipe : public Landmark
{
public:
    template<class... __Args>
    Buoy( __Args&&... args )
    :
        Landmark( Landmark::LandmarkTypes::PIPE, seabee_common::colors::ORANGE, std::forward<__Args>( args )... )
    {
        //
    }
};

// =============================================================================================================================================
class FiringDevice
{
public:
    struct Type
    {
        static const int Shooter = 0;
        static const int Dropper = 1;
    };

    template<int __Type__, class __Id>
    static int getFiringDeviceId( __Id const & id )
    {
        return __Type__ * __Id::size + id.value;
    }

    int device_id_;

    FiringDevice( int const & device_id )
    :
        device_id_( device_id )
    {
        //
    }
};

// =============================================================================================================================================
class Shooter : public FiringDevice
{
public:
    struct Id
    {
        static const int Shooter1 = 0;
        static const int Shooter2 = 1;

        static const int size = 2;

        int value_;

        Id( int const & value ) : value_( value ){}
    };

    Shooter( Id const & id )
    :
        FiringDevice( getDeviceId<FiringDevice::Type::Shooter>( id ) )
    {
        //
    }
};

// =============================================================================================================================================
class Dropper : public FiringDevice
{
public:
    struct Id
    {
        static const int Dropper1 = 0;
        static const int Dropper2 = 1;

        static const int size = 2;

        int value_;

        Id( int const & value ) : value_( value ){}
    };

    Dropper( Id const & id )
    :
        FiringDevice( getDeviceId<FiringDevice::Type::Dropper>( id ) )
    {
        //
    }
};

// =============================================================================================================================================
// =============================================================================================================================================
namespace seabee
{

// #############################################################################################################################################
//! Return the Pose of the landmark with the given name
Pose getPose( std::string const & frame_name );

//! Return the Pose of the sub
/*!
 * - Calls getPose( "seabee" )
 */
Pose getCurrentPose();

// #############################################################################################################################################
//! Fire the given device
ActionToken fireDevice( FiringDevice const & device );

// #############################################################################################################################################
//! Fire the given shooter
/*!
 * - Calls fireDevice( Shooter( shooter_id ) )
 */
ActionToken fireShooter( Shooter::Id const & shooter_id );

//! Fire the given dropper
/*!
 * - Calls fireDevice( Dropper( dropper_id ) )
 */
ActionToken fireDropper( Dropper::Id const & dropper_id );

// #############################################################################################################################################
//! Move to the given pose
/*!
 * - moveTo( getCurrentPose() + Orientation( 90 ) ) will rotate 90 degrees CCW (see faceTo( Orientation ) )
 * - moveTo( getCurrentPose() + Position( 0, 0, -1 ) will dive one meter
 */
ActionToken moveTo( Pose const & pose );

//! Move to some relative position
/*!
 * - Same as moveTo( getCurrentPose() + position )
 */
ActionToken moveTo( Position const & position );

//! Move to some relative orientation
/*!
 * - Same as moveTo( getCurrentPose() + orientation )
 */
ActionToken moveTo( Orientation const & orientation );

// #############################################################################################################################################
//! Face the given position
ActionToken faceTo( Position const & position );

//! Face at the given orientation
ActionToken faceTo( Orientation const & orientation );

// #############################################################################################################################################
//! Strafe around pose.position at current distance until our orientation matches pose.orientation + Degrees( 180 )
ActionToken strafeAround( Pose const & pose );

//! Strafe around pose.position at current distance until our orientation matches orientation
ActionToken strafeAround( Pose const & pose, Orientation const & orientation );

//! Strafe around pose.position at distance until ... (see above)
ActionToken strafeAround( Pose const & pose, double distance, ... );

// #############################################################################################################################################
//! Update the existing landmark filter in-place
/*!
 * - Passing a narrowing filter item follwed by a widening filter item will remove the narrowing filter item
 * - Passing a widening filter item followed by a narrowing filter item will remove the widening filter item
 * - Passing two or more narrowing filter items will join the filter items
 * - Passing an inverted filter item will widen the search, ie { Buoy(), -Buoy( RED ) } will result in all buoys except for red ones
 * - Passing only an inverted filter item will function as if Landmark() was prepended to the list of arguments
 *
 * - Passing just a Landmark() will clear the filter and accept any kind of landmark
 * - Passing a Buoy() will accept any kind of buoy
 * - Passing a Buoy( seabee_common::colors::RED ) will only accept red buoys
 *
 * - Passing { Landmark(), Buoy(), Pipe(), Buoy( RED ) } will result in only pipes and red buoys
 * - Passing { Landmark(), -Buoy( RED ), -Buoy( GREEN ), Pipe() } will result in pipes and yellow buoys
 */
template<class... __Args>
void updateLandmarkFilter( Landmark const & landmark, __Args&&... landmarks )

// #############################################################################################################################################
//! Only look for landmarks that match the given filter
/*!
 * - Calling this function will reset the filter, then apply the given changes
 *
 * - To accept all landmarks, pass: Landmark()
 * - To accept no landmarks, pass: -Landmark()
 */
template<class... __Args>
void setLandmarkFilter( Landmark const & landmark, __Args&&... landmarks );

// #############################################################################################################################################
//! Set (not update) the landmark filter to the specified value and return the resulting landmarks
template<class... __Args>
std::map<std::string, Landmark> getLandmarks( Landmark const & landmark, __Args&&... landmarks );

//! Just get the resulting landmarks
std::map<std::string, Landmark> getLandmarks();

} // seabee

// =============================================================================================================================================
// =============================================================================================================================================

using namespace seabee;

int main()
{
    // look for pipes and red buoys
    // note that items not included in the filter will not have their locations updated automatically via getPose()
    setLandmarkFilter
    (
        Buoy( seabee_common::colors::RED ),
        Pipe()
    );

    // dive one meter
    {
        auto token = moveTo( Position( 0, 0, -1 ) );
    }

    // move one meter above "pipe1"
    {
        auto token = moveTo( getPose( "pipe1" ) + Position( 0, 0, 1 ) );
    }

    // move one meter in front of "buoy1"
    {
        auto token = moveTo( getPose( "buoy1" ) + Position( 1, 0, 0 ) + Orientation( 180 ) );
    }

    // rotate 90 degrees ccw
    {
        auto token = faceTo( Orientation( 90 ) );
    }

    return 0;
}
